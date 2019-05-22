<?php

namespace App\Http\Middleware;

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
        if((!empty(Auth::user()->agreement_id) && Auth::user()->status == 'active') || Auth::user()->user_type == 'admin' || (Auth::user()->plan == 'free' && Auth::user()->status == 'active' )) {
            return $next($request);
        }

        return redirect(route('payment.failed'));
    }
}
