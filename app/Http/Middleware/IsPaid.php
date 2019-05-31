<?php

namespace App\Http\Middleware;

use App\Plan;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsPaid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if($user->payment_method == 'stripe') {
            if(!empty($user->stripe_id)){
                $site_plan = Plan::find($user->plan);
                if($site_plan && $site_plan->stripe_plan) {
                    //if ($user->subscribed($site_plan->stripe_plan)) {
                    if ($user->subscription('main') && !$user->subscription('main')->cancelled()) {
                        return $next($request);
                    }
                }
            }

        }else{
            if ((!empty(Auth::user()->agreement_id) && Auth::user()->status == 'active') || Auth::user()->user_type == 'admin' || (Auth::user()->plan == 'free' && Auth::user()->status == 'active')) {
                return $next($request);
            }
        }

        return redirect(route('payment.failed'));
    }
}
