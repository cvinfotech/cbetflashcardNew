<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Auth;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/web-hook',
        '/web-hook/*',
    ];

    public function handle($request, Closure $next, $guard = null)
    {
        if($this->tokensMatch($request)){
            return tap($next($request), function ($response) use ($request) {
                if ($this->shouldAddXsrfTokenCookie()) {
                    $this->addCookieToResponse($request, $response);
                }
            });

        }else{

            if ($request->_token && Auth::guard($guard)->check()) {

                return tap(redirect('/home'), function ($response) use ($request) {
                    if ($this->shouldAddXsrfTokenCookie()) {
                        $this->addCookieToResponse($request, $response);
                    }
                });

            }

            return tap($next($request), function ($response) use ($request) {
                if ($this->shouldAddXsrfTokenCookie()) {
                    $this->addCookieToResponse($request, $response);
                }
            });
        }


    }
}
