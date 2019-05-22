<?php

namespace App\Http\Controllers;

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
        if(isset($request->event_type) && $request->event_type == 'BILLING.SUBSCRIPTION.CANCELLED') {
            if(isset($request->resource) && isset($request->resource[0])){
                $agreement_id = $request->resource[0]->id;
                $user = User::where('agreement_id', $agreement_id)->first();
                $user->status = '';
                $user->save();
            }
            Log::info($request->all());
        }
    }
}
