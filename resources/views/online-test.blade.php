@extends('layouts.app')
@section('styles')
    <style>

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
                                    <div class="questtions-label page-heading">Online Test</div>

                                    @if(!empty($counter))
                                        <div class="text-right">

                                            <span> <strong>Time Left:</strong> </span>
                                            <span id="timer-hour"></span>
                                            <span id="timer-min"></span>
                                            <span id="timer-sec"></span>
                                            <span id="timer"></span>
                                        </div>
                                    @endif
                                    <div class="test-questions mt-4">
                                        @if($questions->count())
                                            <form method="post" action="{{ route('submit.test') }}">
                                                @csrf
                                                <input type="hidden" value="{{ $test_id }}" name="test_id">
                                                <input type="hidden" name="question_count" id="question_count"
                                                       value="{{ $total_questions }}">
                                                <input type="hidden" name="current_question" id="current_question"
                                                       value="{{ $answered_count }}">
                                                <input type="hidden" name="timer_left" id="timer-left">
                                                @if($questions->count() > 1)
                                                <div class="text-right">
                                                    <button class="w-auto exit-btn btn btn-outline-danger btn-rounded m-0 waves-effect z-depth-0"
                                                            type="submit" name="save" value="save">SAVE & EXIT
                                                    </button>
                                                </div>
                                                @endif

                                                @foreach($questions as $key => $set)
                                                    <div class="question-answer {{ $key == 0  ? 'active' : ''}}">
                                                        <div class="question">{!! $set->question !!}</div>
                                                        <input type="hidden" name="question_id[]"
                                                               value="{{ $set->id }}">
                                                        <div class="options mt-2">
                                                            <!-- Default unchecked -->
                                                            @php
                                                                $options = ['option1' => $set->option1, 'option2' => $set->option2, 'option3' => $set->option3, 'option4' => $set->option4];
                                                                $hints = ['option1' => $set->hint1, 'option2' => $set->hint2, 'option3' => $set->hint3, 'option4' => $set->hint4];
                                                                $option_keys = array_keys($options);
                                                                shuffle($option_keys);
                                                            @endphp
                                                            @foreach($option_keys as $option_key)
                                                                <div class="custom-control custom-radio my-2">
                                                                    <input type="radio"
                                                                           class="custom-control-input option"
                                                                           name="option_{{ $set->id }}"
                                                                           value="{{ $option_key }}">
                                                                    <label class="custom-control-label">{!! $options[$option_key] !!}</label>
                                                                    @if($learn_mode)
                                                                        <div class="alert alert-{{ $set->answer == $option_key ? 'success' : 'danger' }}"
                                                                             role="alert">
                                                                            {!! '<strong>'.($set->answer == $option_key ? 'Correct - ' : 'Wrong - ').'</strong> '.$hints[$option_key] !!}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach


                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if($questions->count() > 1)
                                                    <div class="justify-content-between d-flex flex-row-reverse">
                                                        <button class="w-auto next-btn btn btn-outline-theme btn-rounded my-4 waves-effect z-depth-0"
                                                                type="button">Next Question
                                                        </button>
                                                        <button class="w-auto submit-btn btn btn-outline-theme btn-rounded my-4 waves-effect z-depth-0 hide"
                                                                type="submit" name="submit" value="submit">Submit Test
                                                        </button>

                                                        <button class="w-auto prev-btn btn btn-outline-theme btn-rounded my-4 waves-effect z-depth-0 hide"
                                                                type="button">Previous Question
                                                        </button>




                                                        @else
                                                            <button class="w-auto submit-btn btn btn-outline-theme btn-rounded my-4 waves-effect z-depth-0 "
                                                                    type="submit" name="submit" value="submit">Submit
                                                                Test
                                                            </button>
                                                        @endif

                                                    </div>
                                            </form>
                                            <div class="progress-cat">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped"
                                                         role="progressbar"
                                                         style="width: {{ ($answered_count / $total_questions) * 100 }}%"
                                                         aria-valuenow="{{ ($answered_count / $total_questions) * 100 }}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-danger" role="alert">
                                                No questions

                                            </div>
                                        @endif

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
            @if(empty($learn_mode))
            jQuery(document).on('change', '.question-answer .options input.option', function () {
                var checked = jQuery(this).is(':checked');
                if (checked) {
                    jQuery(this).parents('.question-answer .options').find('.custom-control.custom-radio').addClass('disabled');
                } else {
                    jQuery(this).parents('.question-answer .options').find('.custom-control.custom-radio').removeClass('disabled');
                }
            });
            @endif
            jQuery(document).on('click', '.test-questions .question-answer label.custom-control-label', function () {
                jQuery(this).toggleClass('strike');
                if (jQuery(this).hasClass('strike')) {
                    jQuery(this).siblings('.custom-control-input').attr('disabled', 'disabled');
                } else {
                    jQuery(this).siblings('.custom-control-input').removeAttr('disabled');
                }
            })
            jQuery(document).on('click', 'button.next-btn.btn', function () {
                var $currentItem = jQuery('.test-questions .question-answer.active');
                        @if($learn_mode)
                var $nextItem = $currentItem.next('.question-answer');
                $currentItem.removeClass('active');
                $nextItem.addClass('active');
                if (!$nextItem.next('.question-answer').length) {
                    jQuery(this).addClass('hide');
                    jQuery('.exit-btn').addClass('hide');
                    jQuery('button.submit-btn.btn').removeClass('hide');
                }
                jQuery('button.prev-btn.btn').removeClass('hide');
                var current_ques = parseInt(jQuery('#current_question').val()) + 1;
                var question_count = jQuery('#question_count').val();
                jQuery('#current_question').val(current_ques);

                var progress_count = (current_ques / question_count) * 100;
                jQuery('.progress-bar').css('width', progress_count + '%');
                jQuery('.progress-bar').attr('aria-valuenow', progress_count);
                @else
                if ($currentItem.find('input.option:checked').length) {
                    var $nextItem = $currentItem.next('.question-answer');
                    $currentItem.removeClass('active');
                    $nextItem.addClass('active');
                    if (!$nextItem.next('.question-answer').length) {
                        jQuery(this).addClass('hide');
                        jQuery('.exit-btn').addClass('hide');
                        jQuery('button.submit-btn.btn').removeClass('hide');
                    }
                    jQuery('button.prev-btn.btn').removeClass('hide');
                    var current_ques = parseInt(jQuery('#current_question').val()) + 1;
                    var question_count = jQuery('#question_count').val();
                    jQuery('#current_question').val(current_ques);

                    var progress_count = (current_ques / question_count) * 100;
                    jQuery('.progress-bar').css('width', progress_count + '%');
                    jQuery('.progress-bar').attr('aria-valuenow', progress_count);
                } else {
                    alert('Please select any option');
                }
                @endif
            });
            jQuery(document).on('click', 'button.prev-btn.btn', function () {
                var $currentItem = jQuery('.test-questions .question-answer.active');
                        @if($learn_mode)
                    var $nextItem = $currentItem.prev('.question-answer');
                    $currentItem.removeClass('active');
                    $nextItem.addClass('active');
                    if (!$nextItem.prev('.question-answer').length) {
                        jQuery(this).addClass('hide');
                    }
                jQuery('button.exit-btn.btn').removeClass('hide');
                jQuery('button.submit-btn.btn').addClass('hide');
                jQuery('button.next-btn.btn').removeClass('hide');
                    var current_ques = parseInt(jQuery('#current_question').val()) - 1;
                    var question_count = jQuery('#question_count').val();
                    jQuery('#current_question').val(current_ques);

                    var progress_count = (current_ques / question_count) * 100;
                    jQuery('.progress-bar').css('width', progress_count + '%');
                    jQuery('.progress-bar').attr('aria-valuenow', progress_count);
                @else
                if ($currentItem.find('input.option:checked').length) {
                    var $nextItem = $currentItem.prev('.question-answer');
                    $currentItem.removeClass('active');
                    $nextItem.addClass('active');
                    if (!$nextItem.prev('.question-answer').length) {
                        jQuery(this).addClass('hide');
                    }
                    jQuery('button.exit-btn.btn').removeClass('hide');
                    jQuery('button.submit-btn.btn').addClass('hide');
                    jQuery('button.next-btn.btn').removeClass('hide');
                    var current_ques = parseInt(jQuery('#current_question').val()) - 1;
                    var question_count = jQuery('#question_count').val();
                    jQuery('#current_question').val(current_ques);

                    var progress_count = (current_ques / question_count) * 100;
                    jQuery('.progress-bar').css('width', progress_count + '%');
                    jQuery('.progress-bar').attr('aria-valuenow', progress_count);
                } else {
                    alert('Please select any option');
                }
                @endif
            });

            jQuery(document).on('click', 'button.submit-btn.btn, button.exit-btn.btn', function () {
                var $currentItem = jQuery('.test-questions .question-answer.active');
                if ($currentItem.find('input.option:checked').length) {

                } else {
                    @if(empty($learn_mode))
                    alert('Please select any option');
                    return false;
                    @endif
                }
            });


        })
                @if(!empty($counter))
        var endDate = '{{ $counter }}';

        var timer = setInterval(function () {
            var newDate = new Date()
            let now = newDate.getTime();
            let t = endDate - now;

            if (t >= 0) {

                let hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let mins = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
                let secs = Math.floor((t % (1000 * 60)) / 1000);

                document.getElementById("timer-hour").innerHTML = ("0" + hours).slice(-2) +
                    " : ";

                document.getElementById("timer-min").innerHTML = ("0" + mins).slice(-2) +
                    " : ";

                document.getElementById("timer-sec").innerHTML = ("0" + secs).slice(-2);
                document.getElementById("timer-left").value = t;
            } else {
                document.getElementById("timer-left").value = 0;
                document.getElementById("timer").innerHTML = "The time is over!";

            }

        }, 1000);
        @endif
    </script>
@endsection