<?php

use Carbon\Carbon;
use PayPal\Api\Agreement;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

if(!function_exists('getCategory')){
    function getCategory($cat_id){
        $categories = \App\Category::pluck('name', 'id')->toArray();
        /*$categories = array(
            '1' => 'App',
            '2' => 'Website',
            '3' => 'Payments'
        );*/

        return isset($categories[$cat_id]) ? $categories[$cat_id] : 'Uncategorized';
    }
}
if(!function_exists('getCategories')){
    function getCategories(){
        $categories = \App\Category::pluck('name', 'id')->toArray();
        /*$categories = array(
            '1' => 'App',
            '2' => 'Website',
            '3' => 'Payments'
        );*/

        return $categories;
    }
}

if(!function_exists('getPlans')){
    function getPlans(){
        $plans = \App\Plan::pluck('plan', 'id')->toArray();
        return $plans;
    }
}

if(!function_exists('customCardCount')){
    function customCardCount(){
        $count = \App\Card::where('user_id', Auth::id())->count();
        return $count;
    }
}

if(!function_exists('favoriteCount')){
    function favoriteCount(){
        $count = \App\Favorite::where('user_id', Auth::id())->count();
        return $count;
    }
}
if(!function_exists('randomPassword')) {
    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}

if(!function_exists('getCancelUrl')){
    function getCancelUrl(){
        if(Auth::user()->payment_method == 'stripe'){
            return 'subscription.cancel';
        }else{
            return 'account.cancel';
        }
    }
}

if(!function_exists('getEndDate')){
    function getEndDate(){
        $ends_at = date('Y-m-d');
        $user = Auth::user();
        if($user->payment_method == 'stripe') {
            if(strtotime($user->current_period_end) > time()) {
                $ends_at = Carbon::createFromTimeStamp(strtotime($user->current_period_end))->format('d M, Y');
            }else{
                $subscription = $user->subscription('main')->asStripeSubscription();
                if ($subscription) {
                    $ends_at = Carbon::createFromTimeStamp($subscription->current_period_end)->format('d M, Y');
                }
            }
        }else{
            if(strtotime($user->next_payment_date) > time()) {
                $ends_at = Carbon::createFromTimeStamp(strtotime($user->next_payment_date))->format('d M, Y');
            }else{
                if($user->agreement_id) {
                    if (config('paypal.settings.mode') == 'live') {
                        $client_id = config('paypal.live_client_id');
                        $secret = config('paypal.live_secret');
                    } else {
                        $client_id = config('paypal.sandbox_client_id');
                        $secret = config('paypal.sandbox_secret');
                    }

                    // Set the Paypal API Context/Credentials
                    $apiContext = new ApiContext(new OAuthTokenCredential($client_id, $secret));
                    $apiContext->setConfig(config('paypal.settings'));
                    $cancelAgreementDetails = Agreement::get($user->agreement_id, $apiContext);
                    $user->next_payment_date = Carbon::parse($cancelAgreementDetails->getAgreementDetails()->next_billing_date)->format('Y-m-d H:i:s');
                    $user->save();
                    $ends_at = $user->next_payment_date;
                }else{

                }
            }
        }

        return $ends_at;
    }
}