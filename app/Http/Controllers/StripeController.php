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

        $user->subscription('main')->cancel();
        return back();
    }
}
