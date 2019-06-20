<?php

namespace App\Http\Controllers;

use App\Card;
use App\Category;
use App\Favorite;
use App\OnlineTest;
use App\PaymentHistory;
use App\Plan;
use App\Spotted;
use App\Subscription;
use App\TestHistory;
use App\TestReport;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\AtMost;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('paid')->except('changePlan');
        //$this->middleware('verified');
    }

    public function index(Request $request)
    {
        if (Auth::user()->user_type == 'admin') {
            return redirect(route('admin'));
        } else {
            $topic_cat = $request->topic_cat;
            $cards = Card::select('cards.*', 'favorites.id as favorite_id', 'spotteds.id as spotted_id')->join('categories', 'categories.id', 'cards.cat_id')
                ->leftjoin('favorites', function ($join) {
                    $join->on('favorites.card_id', '=', 'cards.id');
                    $join->on('favorites.user_id', '=', DB::raw(Auth::id()));
                })->leftjoin('spotteds', function ($join) {
                    $join->on('spotteds.card_id', '=', 'cards.id');
                    $join->on('spotteds.user_id', '=', DB::raw(Auth::id()));
                });
            if (!empty($topic_cat)) {
                $cards->where('cat_id', $topic_cat);
            }
            $cards->where(function ($query) {
                return $query->whereNull('cards.user_id')->orWhere('cards.user_id', Auth::id());
            });
            $cards = $cards->get();
            return view('home', compact('cards', 'topic_cat'));
        }
    }

    public function toggleFavorite(Request $request)
    {
        $favorite = Favorite::where('user_id', Auth::id())->where('card_id', $request->card_id);
        if ($favorite->first()) {
            $favorite->delete();
            $count = Favorite::where('card_id', $request->card_id)->count();
            return response()->json(['favorite' => 0, 'count' => $count]);
        } else {
            $favorite = new Favorite;
            $favorite->card_id = $request->card_id;
            $favorite->user_id = Auth::id();
            $favorite->save();
            $count = Favorite::where('card_id', $request->card_id)->count();
            return response()->json(['favorite' => $favorite->id, 'count' => $count]);
        }
    }

    public function allFavorites()
    {
        $favorites = Card::select('cards.*', 'favorites.id as favorite_id')->leftjoin('favorites', 'favorites.card_id', '=', 'cards.id')->where('favorites.user_id', Auth::id())->get();
        return view('all-favorites', compact('favorites'));
    }

    public function addSpotted(Request $request)
    {
        $spotted = Spotted::where('user_id', Auth::id())->where('card_id', $request->card_id);
        if ($spotted->first()) {

        } else {
            $spotted = new Spotted;
            $spotted->card_id = $request->card_id;
            $spotted->user_id = Auth::id();
            $spotted->save();
            return response()->json(['success' => $spotted->id]);
        }
    }


    public function allSpotted()
    {
        $spotteds = Card::select('cards.*', 'spotteds.id as spotted_id')->leftjoin('spotteds', 'spotteds.card_id', '=', 'cards.id')->where('spotteds.user_id', Auth::id())->get();
        return view('all-spotteds', compact('spotteds'));
    }

    public function addCustomCard()
    {
        $route = 'custom.card.store';
        return view('add-custom-card', compact('route'));
    }

    public function editCustomCard($card_id)
    {
        $route = 'custom.card.update';
        $card = Card::find($card_id);
        return view('add-custom-card', compact('route', 'card'));
    }

    public function storeCard(Request $request)
    {
        $rules = [
            'category' => ['required'],
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ];

        if (Input::file('image_question')) {
            $rules['image_question'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
        if (Input::file('image_answer')) {
            $rules['image_answer'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $this->validate($request, $rules);
        if (Input::file('image_question')) {
            $imageQuestionName = time() . '.' . $request->image_question->getClientOriginalExtension();
            $request->image_question->move(base_path(env('UPLOAD_PATH') . 'uploads'), $imageQuestionName);
        }
        if (Input::file('image_answer')) {
            $imageAnswerName = time() . '.' . $request->image_answer->getClientOriginalExtension();
            $request->image_answer->move(base_path(env('UPLOAD_PATH') . 'uploads'), $imageAnswerName);
        }

        $card = new Card;
        $card->cat_id = Input::get('category');
        $card->question = Input::get('question');
        $card->answer = Input::get('answer');
        $card->citation = Input::get('citation');
        if (isset($imageQuestionName)) {
            $card->image_question = $imageQuestionName;
        }
        if (isset($imageAnswerName)) {
            $card->image_answer = $imageAnswerName;
        }
        $card->user_id = Auth::id();
        $saved = $card->save();

        if ($saved) {
            return back()->with('success', 'Card added successfully');
        } else {
            return back()->with('error', 'Card could not be added.');
        }
    }


    public function updateCustomCard(Request $request)
    {
        $rules = [
            'category' => ['required'],
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ];

        if (Input::file('image_question')) {
            $rules['image_question'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
        if (Input::file('image_answer')) {
            $rules['image_answer'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $this->validate($request, $rules);
        if (Input::file('image_question')) {
            $imageQuestionName = time() . '.' . $request->image_question->getClientOriginalExtension();
            $request->image_question->move(base_path(env('UPLOAD_PATH') . 'uploads'), $imageQuestionName);
        }
        if (Input::file('image_answer')) {
            $imageAnswerName = time() . '.' . $request->image_answer->getClientOriginalExtension();
            $request->image_answer->move(base_path(env('UPLOAD_PATH') . 'uploads'), $imageAnswerName);
        }

        $card_id = $request->card_id;
        if ($card_id) {
            $card = Card::find($card_id);
            $card->cat_id = Input::get('category');
            $card->question = Input::get('question');
            $card->answer = Input::get('answer');
            $card->citation = Input::get('citation');
            if (isset($imageQuestionName)) {
                $rmv_path = base_path(env('UPLOAD_PATH') . 'uploads/' . $imageQuestionName);
                unset($rmv_path);
                $card->image_question = $imageQuestionName;
            }
            if (isset($imageAnswerName)) {
                $rmv_path = base_path(env('UPLOAD_PATH') . 'uploads/' . $imageAnswerName);
                unset($rmv_path);
                $card->image_answer = $imageAnswerName;
            }
            $card->user_id = Auth::id();
            $saved = $card->save();
        }

        if ($saved) {
            return back()->with('success', 'Card updated successfully');
        } else {
            return back()->with('error', 'Card could not be updated.');
        }
    }


    public function deleteCustomCard(Request $request)
    {
        $this->validate($request, [
            'card_id' => 'required'
        ]);

        Card::destroy($request->card_id);
        Favorite::where('card_id', $request->card_id)->delete();
        Spotted::where('card_id', $request->card_id)->delete();
        return back()->with('success', 'Successfully deleted');
    }

    public function customCards()
    {
        $cards = Card::where('user_id', Auth::id())->get();
        return view('custom-cards', compact('cards'));
    }

    public function accountSetting()
    {
        $user = Auth::user();
        $end_date = '';
        if($user->payment_method == 'stripe'){
            $sub = Subscription::where('user_id', $user->id)->latest()->first();
            $end_date = $sub->ends_at;
        }
        return view('account-setting', compact('user', 'end_date'));
    }

    public function accountUpdate(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'name' => ['required'],
        ];

        if (!empty(Input::get('password'))) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }
        $this->validate($request, $rules);
        $user->name = Input::get('name');
        if (!empty(Input::get('password'))) {
            $user->password = Hash::make($request->password);
        }
        $saved = $user->save();

        if ($saved) {
            return back()->with('success', 'Saved.');
        } else {
            return back()->with('error', 'Not Saved.');
        }

    }

    public function deleteAccount()
    {
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

    public function payments()
    {
        $payments = PaymentHistory::where('user_id', Auth::id())->paginate(10);
        $payment_method = Auth::user()->payment_method;

        return view('all-payments', compact('payments', 'payment_method'));
    }

    public function checkSpotted()
    {
        $spotted = Spotted::where('user_id', Auth::id())->first();
        if ($spotted) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => true]);
        }
    }

    public function changePlan(Request $request)
    {
        $this->validate($request, [
            'plan' => 'required'
        ]);

        $user = Auth::user();
        $old_plan = $user->plan;
        $user->plan = $request->plan;


        if($request->stripeToken){
            $plan = Plan::find($request->plan);
            $stripe_plan = $plan->stripe_plan;
            $plan_name = $stripe_plan;
            if(isset($request->first_payment) && $request->first_payment == 'done' && $user->subscription('main')) {

                $user->subscription('main')->swap($plan_name);
                $user->updateCard($request->stripeToken);
            }else{
                $subscription = $user->newSubscription('main', $stripe_plan);
                if(!isset($request->first_payment)) {
                    $subscription->trialDays(7);
                }
                $subscription->create($request->stripeToken);
            }
            $subscription = $user->subscription('main')->asStripeSubscription();
            $user->current_period_end = date('Y-m-d H:i:s', $subscription->current_period_end);
            $user->payment_method = 'stripe';
            $user->save();
            return redirect()->route('home');
        }
        $user->save();
        return redirect()->route('paypal.redirect');
    }

    public function configureQuiz()
    {
        $test_histories = TestHistory::where('user_id', Auth::id())->where('status', 'saved')->get();
        return view('configure-quiz', compact('test_histories'));
    }

    public function startTest(Request $request)
    {
        $rules = [
            'test_type' => ['required'],
        ];
        if ($request->test_type == 'quiz') {
            $rules['question_num'] = ['required'];
            $rules['category'] = ['required'];
        }

        $this->validate($request, $rules);

        $test_history = new TestHistory;
        $test_history->user_id = Auth::id();
        $test_history->test_type = $request->test_type;
        $test_history->learn_mode = $request->learn_mode == 'on' ? 1 : 0;
        $test_history->timed = $request->timed == 'on' ? 1 : 0;
        if ($request->test_type == 'quiz') {
            $test_history->cat_id = $request->category;
            $count = OnlineTest::where('cat_id', $request->category)->count();
            $test_history->question_num = $count < $request->question_num ? $count : $request->question_num;
        } else {
            $count = 0;
            $cat1 = OnlineTest::query();
            $cat1 = $cat1->where('cat_id', 1)->limit(20);
            $count += $cat1->count();

            $cat2 = OnlineTest::query();
            $cat2 = $cat2->where('cat_id', 2)->limit(23);
            $count += $cat2->count();

            $cat3 = OnlineTest::query();
            $cat3 = $cat3->where('cat_id', 3)->limit(17);
            $count += $cat3->count();

            $cat4 = OnlineTest::query();
            $cat4 = $cat4->where('cat_id', 4)->limit(41);
            $count += $cat4->count();

            $cat5 = OnlineTest::query();
            $cat5 = $cat5->where('cat_id', 5)->limit(41);
            $count += $cat5->count();

            $cat6 = OnlineTest::query();
            $cat6 = $cat6->where('cat_id', 6)->limit(23);
            $count += $cat6->count();

            $test_history->question_num = $count < 165 ? $count : 165;
        }
        //$test_id = abs( crc32( uniqid() ) );
        $test_id = time();
        $test_history->test_id = $test_id;
        $test_history->status = 'open';
        $test_history->elapsed_time = 0;
        $test_history->save();

        return redirect()->route('online.test', $test_id);

    }

    public function onlineTest($test_id)
    {
        $test_details = TestHistory::where('test_id', $test_id)->first();
        $learn_mode = $test_details->learn_mode;
        $timed = $test_details->timed;
        $elapsed_time = $test_details->elapsed_time;

        $questions = OnlineTest::query();
        if ($test_details->test_type == 'practice') {
            $cat1 = OnlineTest::query();
            $exclude1 = TestReport::select('question_id')->where('test_id', $test_id)->where('cat_id', 1)->pluck('question_id')->toArray();
            $count1 = 20 - count($exclude1);
            $cat1 = $cat1->where('cat_id', 1)->whereNotIn('id', $exclude1)->inRandomOrder()->limit($count1);

            $cat2 = OnlineTest::query();
            $exclude2 = TestReport::select('question_id')->where('test_id', $test_id)->where('cat_id', 2)->pluck('question_id')->toArray();
            $count2 = 23 - count($exclude2);
            $cat2 = $cat2->where('cat_id', 2)->whereNotIn('id', $exclude2)->inRandomOrder()->limit($count2);

            $cat3 = OnlineTest::query();
            $exclude3 = TestReport::select('question_id')->where('test_id', $test_id)->where('cat_id', 3)->pluck('question_id')->toArray();
            $count3 = 17 - count($exclude3);
            $cat3 = $cat3->where('cat_id', 3)->whereNotIn('id', $exclude3)->inRandomOrder()->limit($count3);

            $cat4 = OnlineTest::query();
            $exclude4 = TestReport::select('question_id')->where('test_id', $test_id)->where('cat_id', 4)->pluck('question_id')->toArray();
            $count4 = 41 - count($exclude4);
            $cat4 = $cat4->where('cat_id', 4)->whereNotIn('id', $exclude4)->inRandomOrder()->limit($count4);

            $cat5 = OnlineTest::query();
            $exclude5 = TestReport::select('question_id')->where('test_id', $test_id)->where('cat_id', 5)->pluck('question_id')->toArray();
            $count5 = 41 - count($exclude5);
            $cat5 = $cat5->where('cat_id', 5)->whereNotIn('id', $exclude5)->inRandomOrder()->limit($count5);

            $cat6 = OnlineTest::query();
            $exclude6 = TestReport::select('question_id')->where('test_id', $test_id)->where('cat_id', 6)->pluck('question_id')->toArray();
            $count6 = 23 - count($exclude6);
            $cat6 = $cat6->where('cat_id', 6)->whereNotIn('id', $exclude6)->inRandomOrder()->limit($count6);

            /*  $cat2 = OnlineTest::query();
              $cat2 = $cat2->where('cat_id', 2)->limit(23);
              $cat3 = OnlineTest::query();
              $cat3 = $cat3->where('cat_id', 3)->limit(17);
              $cat4 = OnlineTest::query();
              $cat4 = $cat4->where('cat_id', 4)->limit(41);
              $cat5 = OnlineTest::query();
              $cat5 = $cat5->where('cat_id', 5)->limit(41);
              $cat6 = OnlineTest::query();
              $cat6 = $cat6->where('cat_id', 6)->limit(23);*/
            $answered_count = count($exclude1) + count($exclude2) + count($exclude3) + count($exclude4) + count($exclude5) + count($exclude6);
            $questions = $cat1->unionAll($cat2)->unionAll($cat3)->unionAll($cat4)->unionAll($cat5)->unionAll($cat6)->get();
            //$questions = $cat1->unionAll($cat4)->get();
        } elseif ($test_details->test_type == 'quiz') {
            $exclude1 = TestReport::select('question_id')->where('test_id', $test_id)->where('cat_id', $test_details->cat_id)->pluck('question_id')->toArray();
            $answered_count = count($exclude1);
            $questions = OnlineTest::where('cat_id', $test_details->cat_id)->whereNotIn('id', $exclude1)->inRandomOrder()->limit($test_details->question_num)->get();
        }
        if ($questions->count()) {
            $counter = 0;
            if ($timed) {
                $left_time = 3600 * 3 - (int)$elapsed_time;
                $counter = (microtime(true) + $left_time + 2) * 1000;// + $left_time;
                Session::put('time_start', $counter);
            }

            $questions = $questions->shuffle();
            $total_questions = $test_details->question_num;

            return view('online-test', compact('questions', 'learn_mode', 'timed', 'counter', 'test_id', 'answered_count', 'total_questions'));
        } else {
            return view('online-test', compact('questions', 'learn_mode', 'timed', 'test_id'));
        }
    }

    public function deleteTest($test_id){
       $test_history = TestHistory::where('test_id', $test_id)->delete();
        $test_report = TestReport::where('test_id', $test_id)->delete();
        return back()->with('success', 'Successfully deleted');
    }

    public function submitTest(Request $request)
    {

        $test_id = $request->test_id;
        $test_info = TestHistory::where('test_id', $test_id)->where('status', '!=', 'completed')->first();
        if ($test_info) {
            $timed = $test_info->timed;
            if ($timed) {
                $test_info->elapsed_time = (int)((3600 * 3 * 1000) - $request->timer_left) / 1000;
            }
            if (isset($request->submit)) {
                $test_info->status = 'completed';
            } elseif (isset($request->save)) {
                $test_info->status = 'saved';
            }
            $test_info->save();
            Session::forget('time_start');

            $question_ids = $request->question_id;
            $sets = OnlineTest::find($question_ids);
            $count = $sets->count();
            $score = 0;
            foreach ($sets as $set_key => $set) {
                if (isset($request->{'option_' . $set->id})) {
                    $opted = $request->{'option_' . $set->id};
                    if ($opted == $set->answer) {
                        $score++;
                    }
                    $test_report1 = TestReport::where('test_id', $test_id)->where('question_id', '!=', $set->id)->where('user_id', '!=', Auth::id())->first();

                    if ($test_report1 == null) {
                        $test_report = new TestReport;
                        $test_report->user_id = Auth::id();
                        $test_report->test_id = $test_id;
                        $test_report->question_id = $set->id;
                        $test_report->cat_id = $set->cat_id;
                        $test_report->chosen = $opted;
                        $test_report->correct = $set->answer;
                        $test_report->save();
                    }
                }
            }
            if (isset($request->save)) {
                return redirect()->route('configure.quiz')->with('success', 'Test is saved.');
            }

            $correct = TestReport::join('online_tests', 'test_reports.question_id', '=', 'online_tests.id')->whereRaw('chosen = answer')->where('test_id', $test_id)->count();
            $total = $test_info->question_num;
            $percentage = round(($correct / $total) * 100, 2);
            $test_info->score = $correct;
            if ($test_info->cat_id == null) {
                $passing_marks = 70;
                if ($percentage >= $passing_marks) {
                    $test_info->result = 'passed';
                } else {
                    $test_info->result = 'failed';
                }
            } else {
                $test_info->result = 'quiz';
            }
            $test_info->save();
        }
        return redirect()->route('your.score', $test_id);

    }

    public function yourScore($test_id)
    {
        $test_history = TestHistory::where('test_id', $test_id)->first();
        $total = $test_history->question_num;

        $average_duration = 0;
        if ($test_history->timed) {
            $average_time = $test_history->elapsed_time / $total;
            $average_duration = date('i:s', $average_time);
        }

        $correct = $test_history->score;
        $result = $test_history->result;
        $test_type = $test_history->test_type;
        if ($test_history->test_type == 'practice') {
            $categories = Category::selectRaw('categories.*, (SELECT count(cat_id) as count FROM test_reports WHERE cat_id = categories.id AND test_id = ' . $test_id . ' AND chosen = correct GROUP BY cat_id) as count, (SELECT count(cat_id) as count FROM test_reports WHERE cat_id = categories.id AND test_id = ' . $test_id . ' GROUP BY cat_id) as total')->get();
        } elseif ($test_history->test_type == 'quiz') {
            $categories = Category::selectRaw('categories.*, (SELECT count(cat_id) as count FROM test_reports WHERE cat_id = categories.id AND test_id = ' . $test_id . ' AND chosen = correct GROUP BY cat_id) as count, (SELECT count(cat_id) as count FROM test_reports WHERE cat_id = categories.id AND test_id = ' . $test_id . ' GROUP BY cat_id) as total')->where('id', $test_history->cat_id)->get();
        }

        return view('your-score', compact('correct', 'total', 'average_duration', 'average_time', 'result', 'categories', 'test_id', 'test_type'));
    }

    public function reportCard($test_id)
    {
        $report_card = TestReport::where('test_id', $test_id)->get();

        return view('report-card', compact('report_card'));

    }

    public function testResults()
    {
        $test_results = TestHistory::where('user_id', Auth::id())->where('test_type', 'practice')->where('status', 'completed')->paginate(10);
        $line_graph = TestHistory::selectRaw('DATE_FORMAT(created_at, "%b %d") AS test_date, (SELECT COUNT(*) FROM `test_reports` WHERE test_id = test_histories.test_id AND chosen = correct) as correct')
            ->where('user_id', Auth::id())->where('test_type', 'practice')->where('status', 'completed')->get();



        return view('test-results', compact('test_results', 'line_graph'));
    }

}
