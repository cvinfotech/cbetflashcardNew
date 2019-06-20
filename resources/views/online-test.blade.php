@extends('layouts.app')
@section('styles')
    <style>
        @if(!$learn_mode)
        .alert {
            display: none;
        }
        @endif
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
                                                <divq class="d-flex justify-content-between mb-2">
                                                    <div>
                                                    <div class="questtions-label page-heading">Online Test</div>
                                                    <div class="un-answered">You have <span>x</span> unanswered questions</div>
                                                    </div>

                                                    <button class="w-md-auto exit-btn btn btn-outline-danger btn-rounded m-0 mb-2 btn-sm-block waves-effect z-depth-0"
                                                            type="submit" name="save" value="save">SAVE & EXIT
                                                    </button>
                                                </divq>
                                                @endif
                                                 <br>

                                                @foreach($questions as $key => $set)
                                                    <div class="question-answer {{ $key == 0  ? 'active' : ''}}" id="question-{{ $set->id }}">
                                                        <div class="question">{!! $set->question !!}</div>
                                                        <br>
                                                        <input type="hidden" class="question-input" name="question_id[]"
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
                                                                <div class="custom-control custom-radio my-3">
                                                                    <input type="radio"
                                                                           class="custom-control-input option {{ $option_key }}"
                                                                           name="option_{{ $set->id }}"
                                                                           value="{{ $option_key }}">
                                                                    <label class="custom-control-label">{!! $options[$option_key] !!}
                                                                        @if($learn_mode)
                                                                        <i class="quick-answer fas {{ $set->answer == $option_key ? 'fa-check' : 'fa-times'}}"></i></label>
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
                                                                type="submit" name="submit" value="submit">Submit Quiz
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
    <!-- Modal -->
    <div class="modal fade" id="unAnsQuesModal" tabindex="-1" role="dialog" aria-labelledby="unAnsQuesModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unAnsQuesModalLable">Unanswered Questions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="question-answer">
                        <div class="question"></div>
                        <input type="hidden" class="question-input" name="question_id[]" value="">
                        <div class="options mt-2">
                            <!-- Default unchecked -->
                            <div class="custom-control custom-radio my-2">
                                <input type="radio"
                                       class="custom-control-input option option1"
                                       name="option_0"
                                       value="option1">
                                <label class="custom-control-label">Option 1</label>

                                <div class="alert alert-success"
                                     role="alert">
                                    <strong></strong> <span></span>
                                </div>

                            </div>
                            <div class="custom-control custom-radio my-2">
                                <input type="radio"
                                       class="custom-control-input option option2"
                                       name="option_0"
                                       value="option2">
                                <label class="custom-control-label">Option 2</label>

                                <div class="alert alert-success"
                                     role="alert">
                                    <strong></strong> <span></span>
                                </div>

                            </div>
                            <div class="custom-control custom-radio my-2">
                                <input type="radio"
                                       class="custom-control-input option option3"
                                       name="option_0"
                                       value="option3">
                                <label class="custom-control-label">Option 3</label>

                                <div class="alert alert-success"
                                     role="alert">
                                    <strong></strong> <span></span>
                                </div>

                            </div>

                            <div class="custom-control custom-radio my-2">
                                <input type="radio"
                                       class="custom-control-input option option4"
                                       name="option_0"
                                       value="option4">
                                <label class="custom-control-label">Option 4</label>

                                    <div class="hint alert alert-success"
                                         role="alert">
                                        <strong></strong> <span></span>
                                    </div>

                            </div>



                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between d-flex flex-row-reverse">
                    <button class="w-auto next-modal-btn btn btn-outline-theme btn-rounded my-4 waves-effect z-depth-0"
                            type="button">Next Question
                    </button>
                    <button class="w-auto submit-modal-btn btn btn-outline-theme btn-rounded my-4 waves-effect z-depth-0 hide"
                            type="button" name="submit" value="submit">Submit Quiz
                    </button>

                    <button class="w-auto prev-modal-btn btn btn-outline-theme btn-rounded my-4 waves-effect z-depth-0 hide"
                            type="button">Previous Question
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var allowSaved = false;
        window.onbeforeunload = function() {
            if(!allowSaved) {
                return "Test should be saved or discarded.?";
            }
        };
        jQuery(document).ready(function () {
            jQuery('label.custom-control-label').on('click', function(){

            });
            jQuery(document).on('click', '.question-answer label.custom-control-label', function () {
                jQuery(this).toggleClass('strike');
                if (jQuery(this).hasClass('strike')) {
                    jQuery(this).siblings('.custom-control-input').attr('disabled', 'disabled');
                } else {
                    jQuery(this).siblings('.custom-control-input').removeAttr('disabled');
                }
            })
            jQuery(document).on('click', 'button.next-btn.btn', function () {
                var $currentItem = jQuery('.test-questions .question-answer.active');

                var count = 0;
                var $prevQuestion = $currentItem.prevAll('.question-answer');
                $prevQuestion.each(function(ind, val){
                    count += jQuery(val).find('.options .custom-control-input:checked').length == 0 ? 1 : 0;
                });
                count += $currentItem.find('.options .custom-control-input:checked').length == 0 ? 1 : 0;
                var unanswered = 0;
                if(count >0) {
                    if(count > 1){
                        unanswered = 'You have ' +count+ ' unanswered questions';
                    }else{
                        unanswered = 'You have ' +count+ ' unanswered question';
                    }
                    jQuery('.un-answered').text(unanswered);
                    jQuery('.un-answered').show();
                }else{
                    jQuery('.un-answered').hide();
                }
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

                @endif


            });
            jQuery(document).on('click', 'button.prev-btn.btn', function () {
                var $currentItem = jQuery('.test-questions .question-answer.active');
                var count = 0;
                var $prevQuestion = $currentItem.prevAll('.question-answer');
                $prevQuestion.each(function(ind, val){
                    count += jQuery(val).find('.options .custom-control-input:checked').length == 0 ? 1 : 0;
                });
                var unanswered = 0;
                if(count >0) {
                    if(count > 1){
                        unanswered = 'You have ' +count+ ' unanswered questions';
                    }else{
                        unanswered = 'You have ' +count+ ' unanswered question';
                    }
                    jQuery('.un-answered').text(unanswered);
                    jQuery('.un-answered').show();
                }else{
                    jQuery('.un-answered').hide();
                }
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

                @endif
            });
            var questions = [];
            jQuery(document).on('click', 'button.submit-btn.btn, button.exit-btn.btn', function () {

                allowSaved = true;
                if($(this).hasClass('submit-btn')){
                questions = [];
                var $currentItem = jQuery('.test-questions .question-answer.active');

                var count = 0;

                var $prevQuestion = $currentItem.prevAll('.question-answer');
                if($currentItem.find('.options .custom-control-input:checked').length == 0){
                    count += 1;
                    questions.push($currentItem.find('.question-input').val());
                }
                $prevQuestion.each(function(ind, val){
                    if(jQuery(val).find('.options .custom-control-input:checked').length == 0){
                        count += 1;
                        questions.push(jQuery(val).find('.question-input').val());
                    }
                    //count += jQuery(val).find('.options .custom-control-input:checked').length == 0 ? 1 : 0;
                });

                console.log(questions);
                questions = questions.reverse();
                if(count >0) {
                    var question = jQuery('#question-' + questions[0] + ' .question').text();
                    var options = jQuery('#question-' + questions[0] + ' .options').html();


                    jQuery('.submit-modal-btn, .prev-modal-btn').addClass('hide');
                    jQuery('.next-modal-btn').removeClass('hide');
                    jQuery('#unAnsQuesModal .question-input').val(questions[0]);
                    jQuery('#unAnsQuesModal .question-answer .question').text(question);

                    jQuery('#unAnsQuesModal .question-answer .options').html(options);
                    jQuery('#unAnsQuesModal').modal('show');
                    if (count > 1) {
                        jQuery('#unAnsQuesModal .submit-modal-btn').addClass('hide');
                    } else {
                        jQuery('#unAnsQuesModal .submit-modal-btn').removeClass('hide');
                    }
                    return false;
                }
                }else{

                }
            });

            jQuery(document).on('click','#unAnsQuesModal .next-modal-btn', function () {
                var currentQues = jQuery('#unAnsQuesModal .question-input').val();
                var currentInd = questions.indexOf(currentQues);
                if(jQuery('#unAnsQuesModal .question-answer .options .custom-control-input:checked').length <= 0){
                    alert('Please select a option');
                    return false
                }
                var question = jQuery('#question-'+questions[currentInd+1]+' .question').text();
                var options = jQuery('#question-'+questions[currentInd+1]+' .options').html();

                jQuery('#unAnsQuesModal .question-input').val(questions[currentInd+1]);
                jQuery('#unAnsQuesModal .question-answer .question').text(question);

                jQuery('#unAnsQuesModal .question-answer .options').html(options);
                if((questions.length - 1) <= currentInd + 1){
                    jQuery('#unAnsQuesModal .next-modal-btn').addClass('hide');
                    jQuery('#unAnsQuesModal .submit-modal-btn').removeClass('hide');
                }
                jQuery('#unAnsQuesModal .prev-modal-btn').removeClass('hide');

                jQuery()

            });

            jQuery(document).on('click','#unAnsQuesModal .prev-modal-btn', function () {
                var currentQues = jQuery('#unAnsQuesModal .question-input').val();
                var currentInd = questions.indexOf(currentQues);

                var question = jQuery('#question-'+questions[currentInd-1]+' .question').text();
                var options = jQuery('#question-'+questions[currentInd-1]+' .options').html();

                jQuery('#unAnsQuesModal .question-input').val(questions[currentInd-1]);
                jQuery('#unAnsQuesModal .question-answer .question').text(question);

                jQuery('#unAnsQuesModal .question-answer .options').html(options);
                jQuery('#unAnsQuesModal .next-modal-btn').removeClass('hide');
                if(currentInd - 1 == 0){
                    jQuery('#unAnsQuesModal .prev-modal-btn').addClass('hide');
                }
                jQuery('#unAnsQuesModal .submit-modal-btn').addClass('hide');

            });

            jQuery(document).on('change', '.question-answer .options .custom-control-input', function(){
                var $currentItem = jQuery('.test-questions .question-answer.active');
                console.log($currentItem.prevAll('.question-answer'));
                var count = 0;
                var $prevQuestion = $currentItem.prevAll('.question-answer');
                $prevQuestion.each(function(ind, val){
                    count += jQuery(val).find('.options .custom-control-input:checked').length == 0 ? 1 : 0;
                });
                count += $currentItem.find('.options .custom-control-input:checked').length == 0 ? 1 : 0;
                var unanswered = 0;
                if(count >0) {
                    if(count > 1){
                        unanswered = 'You have ' +count+ ' unanswered questions';
                    }else{
                        unanswered = 'You have ' +count+ ' unanswered question';
                    }
                    jQuery('.un-answered').text(unanswered);
                    jQuery('.un-answered').show();
                }else{
                    jQuery('.un-answered').hide();
                }
            })

        });

        jQuery(document).on('change', '#unAnsQuesModal .question-answer .options .custom-control-input', function(){
            var curVal = jQuery(this).val();
            var question_id = jQuery(this).parents('#unAnsQuesModal').find('.question-input').val();
            jQuery('#question-'+question_id+' .options .custom-control-input.'+curVal).prop("checked", true);
        });

        jQuery(document).on('click','#unAnsQuesModal .submit-modal-btn', function () {
            allowSaved = true;
            jQuery('.submit-btn').click();
        });
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