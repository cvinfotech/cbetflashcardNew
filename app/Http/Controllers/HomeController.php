<?php

namespace App\Http\Controllers;

use App\PaymentHistory;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PayPal\Api\Agreement;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    public function contact(Request $request){
        $this->validate($request, [
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'message1' => ['required', 'string'],
        ]);

        $data = array();
        $data['name'] = Input::get('name');
        $data['email'] = Input::get('email');
        $data['phone'] = Input::get('phone');
        $data['message1'] = Input::get('message1');
        Mail::send('mails.contact', $data, function ($message) {
            $message->to(env('ADMIN_EMAIL'))->subject
            ('CBET: Contact Form Details');
        });

        return back()->with('success', 'We will get back to you as soon as possible, thank you for reaching out.');
    }

    public function clearCache(){
        Artisan::call('cache:clear');
        return "Cache is cleared";
    }

    public function webhook(Request $request){
        if(isset($request->event_type) && ($request->event_type == 'BILLING.SUBSCRIPTION.CANCELLED' || $request->event_type == 'PAYMENT.SALE.DENIED')) {
            if(isset($request->resource) && isset($request->resource[0])){
                $agreement_id = $request->resource[0]->id;
                $user = User::where('agreement_id', $agreement_id)->first();
                if($user->agreement == 'cancelled'){
                    $user->status = 'active';
                }else{
                    $user->status = '';
                }
                $user->save();
            }
        }elseif ($request->type == 'invoice.payment_succeeded'){
            $amount = $request->data['object']['lines']['data'][0]['plan']['amount'];
            $payment_history = new PaymentHistory;
            $payment_history->payment_method = 'stripe';
            $payment_history->transaction_id = $request->data['object']['id'];
            $payment_history->amount = $amount/100;
            $payment_history->status = 'done';
            $customer_id = $request->data['object']['customer'];
            $user = User::where('stripe_id', $customer_id)->first();
            $payment_history->user_id = $user->id;
            $payment_history->save();
            $subscription = $user->subscription('main')->asStripeSubscription();
            $user->current_period_end = date('Y-m-d H:i:s', $subscription->current_period_end);
            $user->save();
        }elseif ($request->type == 'customer.subscription.deleted'){
            $customer_id = $request->data['object']['customer'];
            $user = User::where('stripe_id', $customer_id)->first();
            Subscription::where('user_id', $user->id)->delete();
        }
        Log::info($request->all());
    }

    public function dailyCron(){
        $users = User::all();
        foreach ($users as $user){
            if($user->next_payment_date){
                $next_payment_data = Carbon::createFromTimestamp(strtotime($user->next_payment_date))->format('Y-m-d');
                $now_date = Carbon::now()->format('Y-m-d');
                if($next_payment_data == $now_date && $user->agreement == 'cancelled'){
                    $user->status = '';
                    $user->save();
                }
            }
        }
    }
}
