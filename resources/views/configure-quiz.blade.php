@extends('layouts.app')
@section('styles')
    <style>
        .test-type button.quiz-btn {
            border-left: none !important;
            border: none;
        }

        .test-type button.practice-btn.active {
            border-right: 2px solid #4DCCC0 !important;
        }

        .test-type button.practice-btn.active {
            background: #4dccbd !important;
            color: #fff !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="row">
                        @include('layouts.side-menu')
                        <div class="col-md-9 py-4 pl-lg-0">

                            <div class="mt-0">
                                <div class="col-md-12">
                                    <div class="questtions-label page-heading">Configure Test / Quiz</div>
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ __(session('success')) }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ __(session('error')) }}
                                        </div>
                                    @endif

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="mt-4 font-weight-500">Test Type</div>
                                            <ul class="test-type nav nav-tabs mt-3" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="practice-tab" data-toggle="tab"
                                                       href="#practice" role="tab" aria-controls="practice"
                                                       aria-selected="true">Practice Exam</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="quiz-tab" data-toggle="tab" href="#quiz"
                                                       role="tab"
                                                       aria-controls="quiz"
                                                       aria-selected="false">Quiz</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="practice" role="tabpanel"
                                                     aria-labelledby="practice-tab">
                                                    <form method="post" action="{{ route('start.test') }}">
                                                        @csrf
                                                        <input type="hidden" name="test_type" value="practice">
                                                        <div class="islearnmode mt-4">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       name="learn_mode"
                                                                       id="learn_mode_practice" checked>
                                                                <label class="custom-control-label"
                                                                       for="learn_mode_practice">Learn Mode</label>
                                                            </div>
                                                        </div>
                                                        <small class="small-text">get instant feedback about your answer choice</small>
                                                        <div class="isTimed mt-4">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       name="timed"
                                                                       id="is_timed_practice" checked>
                                                                <label class="custom-control-label"
                                                                       for="is_timed_practice">Timed</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit"
                                                                class="practice-btn w-auto btn btn-outline-theme btn-rounded my-4 waves-effect z-depth-0 mx-0 active">
                                                            GENERATE TEST
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="quiz" role="tabpanel"
                                                     aria-labelledby="quiz-tab">
                                                    <form method="post" action="{{ route('start.test') }}">
                                                        @csrf
                                                        <input type="hidden" name="test_type" value="quiz">
                                                        <div class="mt-4">
                                                            <div class="md-form">
                                                                {{ Form::select('category', getCategories(), '',
                                                                ['required' => 'required', 'class' => 'form-control'.($errors->has('category') ? ' is-invalid' : ''), 'id' => 'category', 'placeholder' => 'Select Category']) }}
                                                                <i class="fas fa-caret-down"></i>
                                                                @if ($errors->has('category'))
                                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('category') }}</strong>
                                                        </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="islearnmode mt-2">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       name="learn_mode"
                                                                       id="learn_mode_quiz" checked>
                                                                <label class="custom-control-label"
                                                                       for="learn_mode_quiz">Learn Mode</label>
                                                            </div>
                                                        </div>
                                                        <small class="small-text">get instant feedback about your answer choice</small>
                                                        <div class="quiz-num">
                                                            <div class="md-form">
                                                                {{ Form::select('question_num', ['10' => '10', '25' => '25', '50' => '50', '100' => '100'], '',
                                                                ['required' => 'required', 'class' => 'form-control'.($errors->has('question_num') ? ' is-invalid' : ''), 'id' => 'question_num', 'placeholder' => 'Select number of questions']) }}
                                                                <i class="fas fa-caret-down"></i>
                                                                @if ($errors->has('question_num'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('question_num') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="isTimed mt-4">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       name="timed"
                                                                       id="is_timed_quiz">
                                                                <label class="custom-control-label"
                                                                       for="is_timed_quiz">Timed</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit"
                                                                class="practice-btn w-auto btn btn-outline-theme btn-rounded my-4 waves-effect z-depth-0 mx-0 active">
                                                            GENERATE QUIZ
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mt-4 font-weight-500">Saved Test and Quizzes</div>
                                            <table class="table mt-3">
                                                <thead class="thead-theme">
                                                <tr>
                                                    <!--<th>S.No</th>-->
                                                    <th>Test Type</th>
                                                    <th>Questions Answered</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($test_histories->count() > 0)
                                                    @foreach($test_histories as $test_key => $test_history)

                                                        <tr>
                                                            <!--<td data-title="S.No">{{-- $test_key + 1 --}}</td>-->
                                                            <td data-title="Test Type">{{ ucfirst($test_history->test_type) }}</td>
                                                            <td data-title="Questions Answered">{{ $test_history->getTestResult->count().'/'.$test_history->question_num }}</td>
                                                            <td data-title="Date">{{ $test_history->created_at->format('d M, Y') }}</td>
                                                            <td data-title="Actions">
                                                                <a href="{{ route('online.test', $test_history->test_id)}}"
                                                                   class=" ">
                                                                    Continue
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">
                                                            You don't have any saved test/quizzes yet.

                                                        </td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        jQuery(document).ready(function () {

        });
    </script>
@endsection