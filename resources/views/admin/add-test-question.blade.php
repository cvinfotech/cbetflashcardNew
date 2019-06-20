@extends('layouts.app')
@section('styles')
    <style>
        .md-form {
            margin-top: 0;
        }

        form label {
            margin-top: 5px;
            margin-bottom: 0;
            font-weight: 500;
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
                                    <!-- Form -->
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

                                    @if(isset($test_question))
                                        <div class="questtions-label page-heading">EDIT TEST QUESTION</div>
                                    @else
                                        <div class="questtions-label page-heading">ADD TEST QUESTION</div>
                                    @endif
                                    {!! Form::open(['route' => $route]) !!}
                                    @csrf
                                <!--  -->
                                    @if(isset($test_question))
                                        {{ Form::hidden('question_id', $test_question->id) }}
                                    @endif
                                    <label for="category">Select Category</label>
                                    <div class="md-form">
                                        {{ Form::select('category', getCategories(), isset($test_question) ? $test_question->cat_id : '',
                                        ['required' => 'required', 'class' => 'form-control'.($errors->has('category') ? ' is-invalid' : ''), 'id' => 'category', 'placeholder' => 'Select Category']) }}
                                        <i class="fas fa-caret-down"></i>
                                        @if ($errors->has('category'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('category') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label for="question">Question?</label>
                                    <div class="md-form">
                                        {{ Form::textarea('question', isset($test_question) ? $test_question->question : '',
                                        ['required' => 'required', 'class' => 'md-textarea form-control'.($errors->has('question') ? ' is-invalid' : ''), 'id' => 'question', 'rows' => 3, 'placeholder' => 'Question?']) }}
                                        <i class="fa fa-question icon"></i>
                                        @if ($errors->has('question'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('question') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label for="category">Option 1</label>
                                    <div class="md-form">
                                        {{ Form::textarea('option1', isset($test_question) ? $test_question->option1 : '',
                                        ['required' => 'required', 'class' => 'md-textarea form-control'.($errors->has('option1') ? ' is-invalid' : ''), 'id' => 'option1', 'rows' => 3, 'placeholder' => 'Option 1']) }}
                                        <i class="fas fa-arrow-left icon"></i>
                                        @if ($errors->has('option1'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('option1') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label for="category">Explanation 1</label>
                                    <div class="md-form">
                                        {{ Form::textarea('hint1', isset($test_question) ? $test_question->hint1 : '',
                                        ['required' => 'required', 'class' => 'md-textarea form-control'.($errors->has('hint1') ? ' is-invalid' : ''), 'id' => 'hint1', 'rows' => 3, 'placeholder' => 'Explanation 1']) }}
                                        <i class="fas fa-info"></i>
                                        @if ($errors->has('hint1'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('hint1') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label for="category">Option 2</label>
                                    <div class="md-form">
                                        {{ Form::textarea('option2', isset($test_question) ? $test_question->option2 : '',
                                        ['required' => 'required', 'class' => 'md-textarea form-control'.($errors->has('option2') ? ' is-invalid' : ''), 'id' => 'option2', 'rows' => 3, 'placeholder' => 'Option 2']) }}
                                        <i class="fas fa-arrow-left icon"></i>
                                        @if ($errors->has('option2'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('option2') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label for="category">Explanation 2</label>
                                    <div class="md-form">
                                        {{ Form::textarea('hint2', isset($test_question) ? $test_question->hint2 : '',
                                        ['required' => 'required', 'class' => 'md-textarea form-control'.($errors->has('hint2') ? ' is-invalid' : ''), 'id' => 'hint2', 'rows' => 3, 'placeholder' => 'Explanation 2']) }}
                                        <i class="fas fa-info"></i>
                                        @if ($errors->has('hint2'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('hint2') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label for="category">Option 3</label>
                                    <div class="md-form">
                                        {{ Form::textarea('option3', isset($test_question) ? $test_question->option3 : '',
                                        ['required' => 'required', 'class' => 'md-textarea form-control'.($errors->has('option3') ? ' is-invalid' : ''), 'id' => 'option3', 'rows' => 3, 'placeholder' => 'Option 3']) }}
                                        <i class="fas fa-arrow-left icon"></i>
                                        @if ($errors->has('option3'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('option3') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label for="category">Explanation 3</label>
                                    <div class="md-form">
                                        {{ Form::textarea('hint3', isset($test_question) ? $test_question->hint3 : '',
                                        ['required' => 'required', 'class' => 'md-textarea form-control'.($errors->has('hint3') ? ' is-invalid' : ''), 'id' => 'hint3', 'rows' => 3, 'placeholder' => 'Explanation 3']) }}
                                        <i class="fas fa-info"></i>
                                        @if ($errors->has('hint3'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('hint3') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label for="category">Option 4</label>
                                    <div class="md-form">
                                        {{ Form::textarea('option4', isset($test_question) ? $test_question->option4 : '',
                                        ['required' => 'required', 'class' => 'md-textarea form-control'.($errors->has('option4') ? ' is-invalid' : ''), 'id' => 'option4', 'placeholder' => 'Option 4']) }}
                                        <i class="fas fa-arrow-left icon"></i>
                                        @if ($errors->has('option4'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('option4') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label for="category">Explanation 4</label>
                                    <div class="md-form">
                                        {{ Form::textarea('hint4', isset($test_question) ? $test_question->hint4 : '',
                                        ['required' => 'required', 'class' => 'md-textarea form-control'.($errors->has('hint4') ? ' is-invalid' : ''), 'id' => 'hint4', 'rows' => 3, 'placeholder' => 'Explanation 4']) }}
                                        <i class="fas fa-info"></i>
                                        @if ($errors->has('hint4'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('hint4') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <label for="category">Select Correct Answer</label>
                                    <div class="md-form">
                                        {{ Form::select('answer', ['option1' => 'Option 1','option2' => 'Option 2','option3' => 'Option 3','option4' => 'Option 4'], isset($test_question) ? $test_question->answer : '',
                                        ['required' => 'required', 'class' => 'form-control'.($errors->has('answer') ? ' is-invalid' : ''), 'id' => 'answer', 'placeholder' => 'Select Correct Answer']) }}
                                        <i class="fas fa-caret-down"></i>
                                        @if ($errors->has('answer'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('answer') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Sign in button -->
                                    <button class="btn btn-outline-theme btn-rounded btn-block my-4 waves-effect z-depth-0"
                                            type="submit">{{ isset($test_question) ? 'EDIT' : 'ADD' }}
                                    </button>


                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
