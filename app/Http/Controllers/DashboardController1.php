<?php

namespace App\Http\Controllers;

use App\Card;
use App\Favorite;
use App\PaymentHistory;
use App\Spotted;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\AtMost;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('paid');
        //$this->middleware('verified');
    }
    public function index(Request $request)
    {
        if(Auth::user()->user_type == 'admin') {
            return redirect(route('admin'));
        }else {
            $topic_cat = $request->topic_cat;
            $cards = Card::select('cards.*', 'favorites.id as favorite_id', 'spotteds.id as spotted_id')->join('categories', 'categories.id', 'cards.cat_id')
                ->leftjoin('favorites', function($join)
             {
                 $join->on('favorites.card_id', '=', 'cards.id');
                 $join->on('favorites.user_id','=', DB::raw(Auth::id()));
             })->leftjoin('spotteds', function($join)
             {
                 $join->on('spotteds.card_id', '=', 'cards.id');
                 $join->on('spotteds.user_id','=', DB::raw(Auth::id()));
             });
            if(!empty($topic_cat)){
                $cards->where('cat_id',$topic_cat);
            }
            $cards->where(function($query){
                return $query->whereNull('cards.user_id')->orWhere('cards.user_id', Auth::id());
            });
            $cards = $cards->get();
            return view('home', compact('cards', 'topic_cat'));
        }
    }

    public function toggleFavorite(Request $request){
        $favorite = Favorite::where('user_id', Auth::id())->where( 'card_id', $request->card_id);
        if($favorite->first()){
            $favorite->delete();
            return response()->json(['success' => '']);
        }else{
            $favorite = new Favorite;
            $favorite->card_id = $request->card_id;
            $favorite->user_id = Auth::id();
            $favorite->save();
            return response()->json(['success' => $favorite->id]);
        }
    }

    public function allFavorites(){
        $favorites = Card::select('cards.*', 'favorites.id as favorite_id')->leftjoin('favorites', 'favorites.card_id','=', 'cards.id')->where('favorites.user_id', Auth::id())->get();
        return view('all-favorites', compact('favorites'));
    }

    public function addSpotted(Request $request){
        $spotted = Spotted::where('user_id', Auth::id())->where('card_id', $request->card_id);
        if($spotted->first()){

        }else{
            $spotted = new Spotted;
            $spotted->card_id = $request->card_id;
            $spotted->user_id = Auth::id();
            $spotted->save();
            return response()->json(['success' => $spotted->id]);
        }
    }


    public function allSpotted(){
        $spotteds = Card::select('cards.*', 'spotteds.id as spotted_id')->leftjoin('spotteds', 'spotteds.card_id','=', 'cards.id')->where('spotteds.user_id', Auth::id())->get();
        return view('all-spotteds', compact('spotteds'));
    }

    public function addCustomCard(){
        $route = 'custom.card.store';
        return view('add-custom-card', compact('route'));
    }

    public function storeCard(Request $request){
        $rules = [
            'category' => ['required'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ];

        if(Input::file('image_question')){
            $rules['image_question'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
        if(Input::file('image_answer')){
            $rules['image_answer'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $this->validate($request, $rules);
        if(Input::file('image_question')) {
            $imageQuestionName = time() . '.' . $request->image_question->getClientOriginalExtension();
            $request->image_question->move(base_path(env('UPLOAD_PATH').'uploads'), $imageQuestionName);
        }
        if(Input::file('image_answer')) {
            $imageAnswerName = time() . '.' . $request->image_answer->getClientOriginalExtension();
            $request->image_answer->move(base_path(env('UPLOAD_PATH').'uploads'), $imageAnswerName);
        }

        $card = new Card;
        $card->cat_id = Input::get('category');
        $card->question = Input::get('question');
        $card->answer = Input::get('answer');
        $card->citation = Input::get('citation');
        if(isset($imageQuestionName)) {
            $card->image_question = $imageQuestionName;
        }
        if(isset($imageAnswerName)) {
            $card->image_answer = $imageAnswerName;
        }
        $card->user_id = Auth::id();
        $saved = $card->save();

        if($saved){
            return back()->with('success', 'Card added successfully');
        }else{
            return back()->with('error', 'Card could not be added.');
        }
    }


    public function customCards(){
        $cards = Card::where('user_id', Auth::id())->get();
        return view('custom-cards', compact('cards'));
    }

    public function accountSetting(){
        $user = Auth::user();
        return view('account-setting', compact('user'));
    }

    public function accountUpdate(Request $request){
        $user = Auth::user();
        $rules = ['password' => ['required', 'string', 'min:8', 'confirmed']];

        $this->validate($request, $rules);

        if(!empty(Input::get('password'))){
            $user->password = Hash::make($request->password);
        }
        $saved = $user->save();

        if($saved){
            return back()->with('success', 'Saved.');
        }else{
            return back()->with('error', 'Not Saved.');
        }

    }

    public function deleteAccount(){
        $user_id = Auth::id();
        Card::where('user_id', $user_id)->delete();
        Favorite::where('user_id', $user_id)->delete();
        Spotted::where('user_id', $user_id)->delete();
        $user = User::find($user_id);

        Auth::logout();
        if ($user->delete()) {
            return redirect()->route('login')->with('global', 'Your account has been deleted!');
        }
    }

    public function payments(){
        $payments = PaymentHistory::where('user_id', Auth::id())->paginate(10);

        return view('all-payments', compact('payments'));
    }

    public function checkSpotted(){
        $spotted = Spotted::where('user_id', Auth::id())->first();
        if($spotted){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['error' => true]);
        }
    }
}
