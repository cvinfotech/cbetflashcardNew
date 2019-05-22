@extends('layouts.app')

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

                                    @if(isset($card))
                                    <div class="questtions-label page-heading">EDIT CARD</div>
                                    @else
                                    <div class="questtions-label page-heading">ADD CARD</div>
                                        <a href="{{ route('category.add') }}" class="text-underline">Add Category</a>
                                    @endif
                                {!! Form::open(['route' => $route, 'files' => 'true']) !!}
                                @csrf
                                <!--  -->
                                    @if(isset($card))
                                    {{ Form::hidden('card_id', $card->id) }}
                                    @endif
                                    <div class="md-form">
                                        {{ Form::select('category', getCategories(), isset($card) ? $card->cat_id : '',
                                        ['required' => 'required', 'class' => 'form-control'.($errors->has('category') ? ' is-invalid' : ''), 'id' => 'category', 'placeholder' => 'Select Category']) }}
                                        <i class="fas fa-caret-down"></i>
                                        @if ($errors->has('category'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('category') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="md-form">
                                        {{ Form::text('question', isset($card) ? $card->question : '',
                                        ['required' => 'required', 'class' => 'form-control'.($errors->has('question') ? ' is-invalid' : ''), 'id' => 'question', 'placeholder' => 'Question?']) }}
                                        <i class="fa fa-question icon"></i>
                                        @if ($errors->has('question'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('question') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="input-default-wrapper mt-3">
                                        <span class="input-group-text mb-3" id="inputQuestion">Upload</span>
                                        {!! Form::file('image_question', ['id' => "image_question", 'class' => "input-default-js".($errors->has('image_question') ? ' is-invalid' : '')]) !!}
                                        <label class="label-for-default-js rounded-right mb-3"
                                               for="image_question"><span class="span-choose-file">Choose file</span>
                                            <div class="float-right span-browse">Browse</div>
                                        </label>
                                        @if ($errors->has('image_question'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('image_question') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    @if(isset($card) && !empty($card->image_question))
                                        <div id="prvImgQuestion">
                                            <img src="{{ asset('uploads/'.$card->image_question) }}" height="70">
                                        </div>
                                    @endif
                                    <div class="md-form">
                                        {{ Form::textarea('answer', isset($card) ? $card->answer : '',
                                        ['required' => 'required', 'class' => 'md-textarea form-control'.($errors->has('answer') ? ' is-invalid' : ''), 'id' => 'answer', 'rows' => 3, 'placeholder' => 'Answer.']) }}
                                        <i class="fa fa-pencil-alt icon"></i>
                                        @if ($errors->has('answer'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('answer') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="input-default-wrapper mt-3">
                                        <span class="input-group-text mb-3" id="inputAnswer">Upload</span>
                                        {!! Form::file('image_answer', ['id' => "image_answer", 'class' => "input-default-js".($errors->has('image_answer') ? ' is-invalid' : '')]) !!}
                                        <label class="label-for-default-js rounded-right mb-3"
                                               for="image_answer"><span class="span-choose-file">Choose file</span>
                                            <div class="float-right span-browse">Browse</div>
                                        </label>
                                        @if ($errors->has('image_answer'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('image_answer') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    @if(isset($card) && !empty($card->image_answer))
                                        <div id="prvImgAnswer">
                                            <img src="{{ asset('uploads/'.$card->image_answer) }}" height="70">
                                        </div>
                                    @endif

                                    <div class="md-form">
                                        {{ Form::textarea('citation', isset($card) ? $card->citation : '',
                                        ['class' => 'form-control md-textarea'.($errors->has('citation') ? ' is-invalid' : ''), 'rows'=>3, 'id' => 'citation', 'placeholder' => 'Citation Information']) }}
                                        <i class="fa fa-pencil icon"></i>
                                        @if ($errors->has('citation'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('citation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <!-- Sign in button -->
                                    <button class="btn btn-outline-theme btn-rounded btn-block my-4 waves-effect z-depth-0"
                                            type="submit">{{ isset($card) ? 'EDIT' : 'ADD' }}
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
