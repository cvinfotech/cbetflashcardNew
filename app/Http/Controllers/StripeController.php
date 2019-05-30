<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Product;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function _constructor()
    {

    }

    public function cancelSubscription(){
        $user = Auth::user();
        if($user->plan) {
            $plan = Plan::find($user->plan);
            if($plan) {
                $stripe_plan = $plan->stripe_plan;
                if($stripe_plan) {
                    $user->subscription($stripe_plan)->cancel();
                    return back();
                }
            }
        }
    }
}
