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
                                    <div class="questtions-label page-heading">Custom Cards</div>
                                    <div class="topic_cards">

                                        @if($cards->count() > 0)
                                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($cards as $key_card => $card)
                                                        <div class="carousel-item p-3 {{ $key_card == 0 ? 'active' : '' }}">
                                                            <div class="flip-card">
                                                                <div class="flip-card-inner">
                                                                    <input type="hidden" value="{{ $card->id }}" class="card_id">
                                                                    <div class="flip-card-front">
                                                                        <div class="top-card"></div>
                                                                        <div class="middle-card">
                                                                            {!! !empty($card->image_question) ? '<img src="'.asset('uploads/'.$card->image_question).'" height="150">' : '' !!}
                                                                            <div class="question">{!! $card->question !!}</div>
                                                                        </div>
                                                                        <div class="bottom-card"></div>
                                                                    </div>
                                                                    <div class="flip-card-back">
                                                                        {!! !empty($card->image_answer) ? '<div class="top-card with_img"><p class="question">'.$card->question.'</p><img src="'.asset('uploads/'.$card->image_answer).'" height="150"></div>' : '<div class="top-card"> <p class="question">'.$card->question.'</p></div>' !!}
                                                                        <div class="middle-card">
                                                                            <div class="answer"><i
                                                                                        class="fas fa-arrow-right"> </i>&nbsp;{!! $card->answer !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="bottom-card">{!! $card->citation ? '<a href="javascript:void(0)" data-toggle="popover" data-placement="top" title="Reference Information" data-content="'.htmlentities($card->citation).'" data-html="true">Reference information</a>' : '' !!}</div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                                <div class="navigations mt-3">
                                                    <button class="bg-transaparent left-btn disabled"><i class="fas fa-arrow-left"></i></button>
													<button class="bg-transaparent edit-btn"><i class="fas fa-pencil-alt"></i></button>
                                                    <button class="btn btn-dark toggle-card mx-3">Show Answer</button>
													<button class="bg-transaparent delete-btn" data-toggle="modal"
                                                       data-target="#deleteCardModal"><i class="fas fa-trash"></i></button>

                                                    <button class="bg-transaparent right-btn {{ $cards->count() == 1 ? 'disabled' : '' }}"><i class="fas fa-arrow-right"></i></button>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert " role="alert">
                                                You haven’t created any custom flashcards yet. <a href="{{ route('custom.card.add') }}">Click here</a> to add one.
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
    <div class="modal fade" id="citationModal" tabindex="-1" role="dialog" aria-labelledby="citationModal"
         aria-hidden="true">

        <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="citationModalLongTitle">Citation Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
	
	   <!-- Modal -->
    <div class="modal fade" id="deleteCardModal" tabindex="-1" role="dialog" aria-labelledby="deleteCardModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => 'custom.card.delete', 'method' => 'DELETE']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCardModalLable">Alert</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('card_id', '', ['class' => 'delete_id']) !!}
                    Are you sure you want to delete this card?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.carousel').carousel({
            interval: false,
            wrap:false,
            touch:false
        });
        $('.navigations button.left-btn').on('click', function(){
            $('a.carousel-control-prev').click();
            $('.topic_cards .carousel-item .flip-card').removeClass('active');
            var text = 'Show Answer';
            $('.topic_cards .carousel button.toggle-card').text(text);
        });
        $('.navigations button.right-btn').on('click', function(){
            $('a.carousel-control-next').click();
            $('.topic_cards .carousel-item .flip-card').removeClass('active');
            var text = 'Show Answer';
            $('.topic_cards .carousel button.toggle-card').text(text);
        });
        $('.topic_cards .carousel button.toggle-card').on('click', function(){
            $('.topic_cards .carousel-item.active .flip-card').toggleClass('active');
            var text = $(this).text() == 'Show Answer' ? 'Show Question' : 'Show Answer';
            $(this).text(text);
        });

        $('.carousel').on('slid.bs.carousel', function () {
            var $current = $('.topic_cards .carousel-item.active');
            var nextElem = $current.next();
            if(!nextElem.length) {
                $('.topic_cards .carousel button.right-btn').addClass('disabled');
            }else{
                $('.topic_cards .carousel button.right-btn').removeClass('disabled');
            }

            var prevElem = $current.prev();
            if(!prevElem.length) {
                $('.topic_cards .carousel button.left-btn').addClass('disabled');
            }else {
                $('.topic_cards .carousel button.left-btn').removeClass('disabled');
            }
        });

        $('#deleteCardModal').on('show.bs.modal', function (e) {
            var card_id = $('.carousel-item.active .flip-card-inner input.card_id').val();
			$('#deleteCardModal .modal-body input.delete_id').val(card_id);
        });
		
		$('.edit-btn').click(function(){
			var card_id = $('.carousel-item.active .flip-card-inner input.card_id').val();
			window.location.href = 'edit-custom-card/'+card_id;
		});
		
		$('[data-toggle="popover"]').popover()

    </script>
@endsection