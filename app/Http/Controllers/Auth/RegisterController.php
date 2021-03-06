<?php

namespace App\Http\Controllers\Auth;

use App\Plan;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = route('paypal.redirect');
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'plan' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'approve_terms' => ['required'],
        ], [
            'email.unique' => 'This email is already in use.',
            'approve_terms.required' => 'You must agree to the terms and conditions before you can register.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'plan' => $data['plan'],
            'payment_method' => $data['payment_method'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);
        if($request->stripeToken){
            $plan = Plan::find($request->plan);
            $stripe_plan = $plan->stripe_plan;
            $plan_name = $stripe_plan;
            $user->newSubscription('main', $stripe_plan)
                ->trialDays(7)
                ->create($request->stripeToken);
            $this->redirectTo = '/home';
            $subscription = $user->subscription('main')->asStripeSubscription();
            $user->current_period_end = date('Y-m-d H:i:s', $subscription->current_period_end);
            $user->save();
        }
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
