<?php

namespace App\Http\Controllers;

use App\PaymentHistory;
use App\User;
use Illuminate\Http\Request;

// Used to process plans
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PayPal\Api\Agreement;
use PayPal\Api\Amount;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Transactions;
use PayPal\Common\PayPalModel;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PHPUnit\TextUI\ResultPrinter;

class PaypalController extends Controller
{
    private $apiContext;
    private $mode;
    private $client_id;
    private $secret;

    // Create a new instance with our paypal credentials
    public function __construct()
    {
        $this->middleware('auth');
        // Detect if we are running in live mode or sandbox
        if(config('paypal.settings.mode') == 'live'){
            $this->client_id = config('paypal.live_client_id');
            $this->secret = config('paypal.live_secret');
        } else {
            $this->client_id = config('paypal.sandbox_client_id');
            $this->secret = config('paypal.sandbox_secret');
        }

        // Set the Paypal API Context/Credentials
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));
    }

    public function create_plan($plan_id){


        $site_plan = \App\Plan::find($plan_id);
        // Create a new billing plan
        $plan = new Plan();
        $plan->setName($site_plan->plan)
            ->setDescription($site_plan->description)
            ->setType('fixed');

        // Set billing plan definitions
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Payment to '.env('APP_NAME'))
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval($site_plan->months)
            ->setCycles(1)
            ->setAmount(new Currency(array('value' => $site_plan->amount, 'currency' => 'USD')));

        Log::info(env('APP_URL').'/subscribe/paypal/return/jovin');
        // Set merchant preferences
        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(env('APP_URL').'/subscribe/paypal/return')
            ->setCancelUrl(env('APP_URL').'/subscribe/paypal/return')
            ->setAutoBillAmount('yes')
            ->setInitialFailAmountAction('CONTINUE')
            ->setMaxFailAttempts('0');

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        //create the plan
        try {
            $createdPlan = $plan->create($this->apiContext);
            try {
                $patch = new Patch();
                $value = new PayPalModel('{"state":"ACTIVE"}');
                $patch->setOp('replace')
                    ->setPath('/')
                    ->setValue($value);
                $patchRequest = new PatchRequest();
                $patchRequest->addPatch($patch);
                $createdPlan->update($patchRequest, $this->apiContext);
                $plan = Plan::get($createdPlan->getId(), $this->apiContext);

                // Output plan id
                //echo 'Plan ID:' . $plan->getId();
                $site_plan->plan_id = $plan->getId();
                $site_plan->save();
                return redirect()->route('plans.all')->with('success', 'Plan added successfully');
            } catch (PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            } catch (\Exception $ex) {
                die($ex);
            }
        } catch (PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (\Exception $ex) {
            die($ex);
        }

    }

    public function delete_plan($plan_id){
        try {
            // Set plan id
            $plan = new Plan();
            $plan->setId($plan_id);
            $result = $plan->delete($this->apiContext);
            return redirect()->route('plans.all');
        } catch (\Exception $ex) {
            ResultPrinter::printError("Deleted a Plan", "Plan", $plan->getId(), null, $ex);
            exit(1);
        }
    }

    public function paypalRedirect(){
        $dd = \Carbon\Carbon::now()->addMinutes(5)->toIso8601String();
        $plan_ind = Auth::user()->plan;
        $site_plan = \App\Plan::find($plan_ind);
        // Create new agreement
        $agreement = new Agreement();
        $agreement->setName(env('APP_NAME').': '.$site_plan->name.' Agreement')
            ->setDescription('Basic Agreement')
            ->setStartDate(\Carbon\Carbon::now()->addMinutes(5)->toIso8601String());

        // Set plan id
        $plan = new Plan();
        $plan->setId($site_plan->plan_id);
        $agreement->setPlan($plan);

        // Add payer type
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        try {
            // Create agreement
            $agreement = $agreement->create($this->apiContext);

            // Extract approval URL to redirect user
            $approvalUrl = $agreement->getApprovalLink();

            return redirect($approvalUrl);
        } catch (PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (\Exception $ex) {
            die($ex);
        }

    }

    public function paypalReturn(Request $request){



        $token = $request->token;
        $agreement = new \PayPal\Api\Agreement();

        try {
            // Execute agreement
            $plan_ind = Auth::user()->plan;
            $site_plan = \App\Plan::find($plan_ind);

            $result = $agreement->execute($token, $this->apiContext);

            $user = Auth::user();

            if(isset($result->id)){
                $user->agreement_id = $result->id;
                $user->status = 'active';
                $agreement_id = $result->id;
            }
            $user->save();
            $status = 'Done';
            echo 'New Subscriber Created and Billed';
            $msg_status = 'success';
            $payment_msg = "Payment succuss";

        } catch (PayPalConnectionException $ex) {
            $user = Auth::user();
            $user->status = 'active';
            $user->save();
            $status = "Failed";
            $agreement_id = '';
            $msg_status = 'error';
            $payment_msg = 'You have either cancelled the request or your session has expired';
        }

        $payHistory = new PaymentHistory;
        $payHistory->transaction_id = $token;

        $payHistory->amount = $site_plan->amount;
        $payHistory->status = $status;
        $payHistory->user_id = Auth::id();
        $payHistory->agreement_id = $agreement_id;
        $payHistory->save();

        //return redirect($approvalUrl);
        return redirect()->route('home')->with($msg_status, $payment_msg);
    }

    public function paypalFailed(){

        return view('payment-failed');
    }

    public function webhookr(Request $request){
        $data = array('start_date=2018-04-01T00:00:00-0700&end_date=2018-04-30T00:00:00-0700');
        $transactions = Payment::all($data, $this->apiContext);
        //$amount = $transactions->getAmount();
        dd($transactions);
       /* $params = array('start_date' => date('Y-m-d', strtotime('-15 years')), 'end_date' => date('Y-m-d', strtotime('+5 days')));


            $result = Agreement::searchTransactions(Auth::user()->agreement_id, $params, $this->apiContext);
            dd($result);

        $paymentId = $request->paymentId;
        $payment = Payment::get($paymentId, $this->apiContext);
        dd($payment);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        $transaction = new Transaction();
        $amount = new Amount();
        $amount->setCurrency('USD');
        $amount->setTotal();*/


    }


}
