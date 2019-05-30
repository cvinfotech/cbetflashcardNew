<?php

namespace App\Http\Controllers;

use App\Card;
use App\Category;
use App\Favorite;
use App\OnlineTest;
use App\PaymentHistory;
use App\Plan;
use App\Spotted;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        //$this->middleware('verified');
    }

    public function index(Request $request)
    {
        $users_count = User::count();
        $cards_count = Card::count();
        $monthly_transcation = PaymentHistory::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('amount');
        $cards = Card::select('cards.*', 'users.name AS user_name')->leftjoin('users', 'users.id', 'cards.user_id');
        $search_card = $request->search_card;
        if(!empty($search_card)){
            $cards->where('question','like','%'.$search_card.'%');
        }
        $cards = $cards->orderBy('id', 'desc')->paginate(10);
        return view('admin.home', compact('cards','users_count', 'search_card', 'cards_count', 'monthly_transcation'));
    }

    public function addCard()
    {
        $route = 'card.store';
        return view('admin.add-card', compact('route'));
    }

    public function editCard($card_id)
    {
        $card = Card::find($card_id);
        $route = 'card.update';
        return view('admin.add-card', compact('card', 'route'));
    }

    public function storeCard(Request $request){
        $rules = [
            'category' => ['required'],
            'question' => ['required', 'string'],
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
        $saved = $card->save();

        if($saved){
            return back()->with('success', 'Card added successfully');
        }else{
            return back()->with('error', 'Card could not be added.');
        }
    }

    public function updateCard (Request $request){
        $rules = [
            'category' => ['required'],
            'question' => ['required', 'string'],
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

        $card_id = $request->card_id;
        if($card_id){
            $card = Card::find($card_id);
            $card->cat_id = Input::get('category');
            $card->question = Input::get('question');
            $card->answer = Input::get('answer');
            $card->citation = Input::get('citation');
            if(isset($imageQuestionName)) {
                $rmv_path = base_path(env('UPLOAD_PATH').'uploads/'.$imageQuestionName);
                unset($rmv_path);
                $card->image_question = $imageQuestionName;
            }
            if(isset($imageAnswerName)) {
                $rmv_path = base_path(env('UPLOAD_PATH').'uploads/'.$imageAnswerName);
                unset($rmv_path);
                $card->image_answer = $imageAnswerName;
            }
            $saved = $card->save();
        }

        if($saved){
            return back()->with('success', 'Card updated successfully');
        }else{
            return back()->with('error', 'Card could not be updated.');
        }
    }

    public function addUser(){
        $route = 'user.create';
        return view('admin.add-user', compact('route'));
    }

    public function allUsers(){
        $users = User::select('users.*', 'plans.plan as plan_name')->whereNull('user_type')->leftjoin('plans', 'plans.id', 'users.plan')->paginate(10);
        return view('admin.all-users', compact('users'));
    }

    public function createUser(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ];
        $this->validate($request, $rules);

        $generated_password = randomPassword();

        $user = new User;
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        $user->password = Hash::make($generated_password);
        $user->plan = 'free';
        $user->status = 'active';

        $saved = $user->save();

        $data = array();
        $data['name'] = Input::get('name');
        $email = $data['email'] = Input::get('email');
        $data['plan'] = 'free';
        $data['password'] = $generated_password;
        Mail::send('mails.user-created', $data, function ($message) use($email) {
            $message->to($email)->subject
            ('Account created on '.env('APP_NAME'));
        });

        if($saved){
            return back()->with('success', 'User created successfully.');
        }else{
            return back()->with('error', 'User could not be created.');
        }
    }

    public function deleteCard(Request $request){
        $this->validate($request,[
            'card_id' => 'required'
        ]);

        Card::destroy($request->card_id);
        Favorite::where('card_id', $request->card_id)->delete();
        Spotted::where('card_id', $request->card_id)->delete();
        return back()->with('success', 'Successfully deleted');
    }

    public function deleteUser(Request $request){
        $this->validate($request,[
            'user_id' => 'required'
        ]);

        User::destroy($request->user_id);
        return back()->with('success', 'Successfully deleted');
    }

    public function allPlans(){
        $plans = Plan::paginate(10);
        return view('admin.all-plans', compact('plans'));
    }

    public function deletePlan(Request $request){
        $this->validate($request,[
            'plan_id' => 'required'
        ]);


        $plan = Plan::find($request->plan_id);
        $plan_id = $plan->plan_id;
        $plan->delete();

        return redirect()->route('delete.paypal.plan', $plan_id)->with('success', 'Successfully deleted');
    }

    public function storePlan(Request $request){
        $this->validate($request, [
            'plan' => ['required', 'string', 'max:255'],
            'amount' => ['required'],
            'months' => ['required'],
            'description' => ['required'],
        ]);

        $plan = new Plan;
        $plan->plan = Input::get('plan');
        $plan->amount = Input::get('amount');
        $plan->months = Input::get('months');
        $plan->description = Input::get('description');
        $created = $plan->save();

        if($created){
            //return back()->with('success', 'Plan added successfully');
            return redirect()->route('create.paypal.plan', $plan->id)->with('success', 'Plan added successfully');
        }else{
            return back()->with('error', 'Plan could not be added.');
        }
    }

    public function updatePlan(Request$request){
        $this->validate($request, [
            'plan_id' => ['required'],
            'plan' => ['required', 'string', 'max:255'],
            'amount' => ['required'],
        ]);

        $plan = Plan::find($request->plan_id);
        $plan->plan = Input::get('plan');
        $plan->amount = Input::get('amount');
        $updated = $plan->save();

        if($updated){
            return back()->with('success', 'Plan updated successfully.');
        }else{
            return back()->with('error', 'Plan could not be updated.');
        }
    }

    public function account(){
        $user = Auth::user();
        return view('admin.account', compact('user'));
    }

    public function updateAccount(Request $request){
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

    public function allCategories(){
        $all_category = Category::paginate(10);
        return view('admin.all-categories', compact('all_category'));
    }

    public function addCategory(){
        $route = 'category.store';
        return view('admin.add-category', compact('route'));
    }

    public function editCategory($category_id)
    {
        $category = Category::find($category_id);
        $route = 'category.update';
        return view('admin.add-category', compact('category', 'route'));
    }

    public function storeCategory(Request $request){
        $rules = [
            'name' => ['required'],
        ];
        $this->validate($request, $rules);
        $category = new Category;
        $category->name = Input::get('name');

        $saved = $category->save();

        if($saved){
            return back()->with('success', 'Category added successfully');
        }else{
            return back()->with('error', 'Category could not be added.');
        }
    }

    public function updateCategory (Request $request){
        $rules = [
            'name' => ['required'],
        ];
        $this->validate($request, $rules);


        $category_id = $request->category_id;
        if($category_id){
            $category = Category::find($category_id);
            $category->name = Input::get('name');
            $saved = $category->save();
        }

        if($saved){
            return back()->with('success', 'Category updated successfully');
        }else{
            return back()->with('error', 'Category could not be updated.');
        }
    }

    public function deleteCategory(Request $request){
        $this->validate($request,[
            'category_id' => 'required'
        ]);

        Category::destroy($request->category_id);
        return back()->with('success', 'Successfully deleted');
    }

    public function onlineTest(Request $request){
        $online_tests = OnlineTest::query();
        $search_ques = $request->search_ques;
        if(!empty($search_ques)){
            $online_tests->where('question','like','%'.$search_ques.'%');
        }
        $online_tests = $online_tests->paginate(10);
        return view('admin.online-test', compact('online_tests', 'search_ques'));
    }

    public function addTestQuestion(){
        $route = 'store.test-question';
        return view('admin.add-test-question', compact('route'));
    }

    public function storeTestQuestion(Request $request){
        $rules = [
            'category' => ['required'],
            'question' => ['required', 'string'],
            'option1' => ['required', 'string'],
            'option2' => ['required', 'string'],
            'option3' => ['required', 'string'],
            'option4' => ['required', 'string'],
            'hint1' => ['required', 'string'],
            'hint2' => ['required', 'string'],
            'hint3' => ['required', 'string'],
            'hint4' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ];

        $this->validate($request, $rules);

        $test_question = new OnlineTest;
        $test_question->cat_id = Input::get('category');
        $test_question->question = Input::get('question');
        $test_question->option1 = Input::get('option1');
        $test_question->option2 = Input::get('option2');
        $test_question->option3 = Input::get('option3');
        $test_question->option4 = Input::get('option4');

        $test_question->hint1 = Input::get('hint1');
        $test_question->hint2 = Input::get('hint2');
        $test_question->hint3 = Input::get('hint3');
        $test_question->hint4 = Input::get('hint4');

        $test_question->answer = Input::get('answer');

        $saved = $test_question->save();

        if($saved){
            return back()->with('success', 'Question added successfully');
        }else{
            return back()->with('error', 'Question could not be added.');
        }
    }

    public function editTestQuestion($question_id){
        $route = 'update.test-question';
        $test_question = OnlineTest::find($question_id);
        return view('admin.add-test-question', compact('test_question', 'route'));
    }

    public function updateTestQuestion (Request $request){
        $rules = [
            'category' => ['required'],
            'question' => ['required', 'string'],
            'option1' => ['required', 'string'],
            'option2' => ['required', 'string'],
            'option3' => ['required', 'string'],
            'option4' => ['required', 'string'],
            'hint1' => ['required', 'string'],
            'hint2' => ['required', 'string'],
            'hint3' => ['required', 'string'],
            'hint4' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ];

        $this->validate($request, $rules);

        $question_id = $request->question_id;
        if($question_id){
            $test_question = OnlineTest::find($question_id);
            $test_question->cat_id = Input::get('category');
            $test_question->question = Input::get('question');
            $test_question->option1 = Input::get('option1');
            $test_question->option2 = Input::get('option2');
            $test_question->option3 = Input::get('option3');
            $test_question->option4 = Input::get('option4');

            $test_question->hint1 = Input::get('hint1');
            $test_question->hint2 = Input::get('hint2');
            $test_question->hint3 = Input::get('hint3');
            $test_question->hint4 = Input::get('hint4');

            $test_question->answer = Input::get('answer');

            $saved = $test_question->save();
        }

        if($saved){
            return back()->with('success', 'Question updated successfully');
        }else{
            return back()->with('error', 'Question could not be updated.');
        }
    }

    public function deleteTestQuestion(Request $request){
        $this->validate($request,[
            'question_id' => 'required'
        ]);

        OnlineTest::destroy($request->question_id);

        return back()->with('success', 'Successfully deleted');
    }
}
