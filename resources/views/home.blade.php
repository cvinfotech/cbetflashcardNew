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
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="spotted-times hide">Spotted on test <span class="spotted-count">0</span>
                                                times
                                            </div>

                                            <div class="favorited-times">Favorited <span class="favorited-count">
                                                    {{ isset($cards[0]) ? \App\Favorite::where('card_id', $cards[0]->id)->count() : 0 }}
                                                </span> times
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button id="random_btn"
                                                    class="btn  random-btn m-0 btn-outline-theme btn-rounded btn-block waves-effect z-depth-0">
                                                Random
                                            </button>
                                        </div>

                                        @if (session('success'))
                                            <div class="col-md-12">
                                                <div class="alert alert-success" role="alert">
                                                    {{ __(session('success')) }}
                                                </div>
                                            </div>
                                        @endif
                                        @if (session('error'))
                                            <div class="col-md-12">
                                                <div class="alert alert-danger" role="alert">
                                                    {{ __(session('error')) }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="topic_cards">

                                        @if($cards->count() > 0)
                                            <div id="carouselExampleControls" class="carousel slide"
                                                 data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($cards as $key_card => $card)
                                                        @php
                                                            $spottedOnTest = \App\Spotted::where('card_id', $card->id)->count();
                                                            $favorited = \App\Favorite::where('card_id', $card->id)->count();
                                                        @endphp
                                                        <div class="carousel-item p-3 {{ $key_card == 0 ? 'active' : '' }}">
                                                            <div class="flip-card">
                                                                <div class="flip-card-inner">
                                                                    <input type="hidden" value="{{ $card->id }}"
                                                                           class="card_id">
                                                                    <input type="hidden"
                                                                           value="{{ $card->favorite_id }}"
                                                                           class="favorite_id">
                                                                    <input type="hidden" value="{{ $card->spotted_id }}"
                                                                           class="spotted_id">
                                                                    <input type="hidden" value="{{ $spottedOnTest }}"
                                                                           class="spotted_count">
                                                                    <input type="hidden" value="{{ $favorited }}"
                                                                           class="favorited_count">
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
                                                                        <div class="bottom-card">{!! $card->citation ? '<a href="javascript:void(0)" data-toggle="popover" data-placement="top" title="Reference Information" data-content="'.htmlentities($card->citation).'" data-html="true" >Reference information</a>' : '' !!}</div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleControls"
                                                   role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleControls"
                                                   role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                                <div class="navigations mt-3">
                                                    <button class="bg-transaparent left-btn disabled"><i
                                                                class="fas fa-arrow-left"></i></button>
                                                    @if($cards[0]->favorite_id)
                                                        <button class="bg-transaparent fav-btn heart"><i
                                                                    class="fas fa-heart"></i></button>
                                                    @else
                                                        <button class="bg-transaparent fav-btn "><i
                                                                    class="far fa-heart"></i></button>
                                                    @endif
                                                    <button class="btn btn-dark toggle-card mx-3">Show Answer</button>
                                                    <button class="bg-transaparent random-btn random"><i
                                                                class="fas fa-random"></i></button>
                                                    @if($cards[0]->spotted_id && false)
                                                        <button class="bg-transaparent spotted-btn spotted"><i
                                                                    class="fas fa-crosshairs"></i></button>
                                                    @elseif(false)
                                                        <button class="bg-transaparent spotted-btn"><i
                                                                    class="fas fa-crosshairs"></i></button>
                                                    @endif

                                                    <button class="bg-transaparent right-btn {{ $cards->count() == 1 ? 'disabled' : '' }}">
                                                        <i class="fas fa-arrow-right"></i></button>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-danger" role="alert">
                                                {{ 'No Card for this category' }}
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
@endsection
@section('scripts')
    <script>
        $('.carousel').carousel({
            interval: false,
            wrap: false,
            touch: false
        });
        $('.navigations button.left-btn').on('click', function () {
            $('a.carousel-control-prev').click();
            $('.topic_cards .carousel-item .flip-card').removeClass('active');
            var text = 'Show Answer';
            $('.topic_cards .carousel button.toggle-card').text(text);
        });
        $('.navigations button.right-btn').on('click', function () {
            $('a.carousel-control-next').click();
            $('.topic_cards .carousel-item .flip-card').removeClass('active');
            var text = 'Show Answer';
            $('.topic_cards .carousel button.toggle-card').text(text);
        });
        $('.topic_cards .carousel button.toggle-card').on('click', function () {
            $('.topic_cards .carousel-item.active .flip-card').toggleClass('active');
            var text = $(this).text() == 'Show Answer' ? 'Show Question' : 'Show Answer';
            $(this).text(text);
        });
        $('.topic_cards .carousel .navigations .fav-btn').on('click', function () {
            var card_id = $('.topic_cards .carousel-item.active input.card_id').val();
            var favorite_id = $('.topic_cards .carousel-item.active input.favorite_id').val();

            $.ajax({
                url: '{{ route('favorite.toggle') }}',
                data: {card_id: card_id, favorite_id: favorite_id, _token: '{{ csrf_token() }}'},
                type: 'POST',
                success: function (response) {
                    if (response.favorite != 0) {
                        $('.topic_cards .carousel .navigations .fav-btn').addClass('heart');
                        $('.topic_cards .carousel .navigations .fav-btn i').addClass('fas');
                        $('.topic_cards .carousel .navigations .fav-btn i').removeClass('far');
                    } else {
                        $('.topic_cards .carousel .navigations .fav-btn').removeClass('heart');
                        $('.topic_cards .carousel .navigations .fav-btn i').addClass('far');
                        $('.topic_cards .carousel .navigations .fav-btn i').removeClass('fas');
                    }
                    $('.topic_cards .carousel-item.active input.favorited_count').val(response.count);
                    $('.topic_cards .carousel-item.active input.favorite_id').val(response.favorite);
                    $('.favorited-times span.favorited-count').text(response.count);
                }
            });

        });
        $('.topic_cards .carousel .navigations .spotted-btn').on('click', function () {
            if ($(this).hasClass('spotted')) {
                alert('You have marked this question down as being on the test');
            } else {
                var card_id = $('.topic_cards .carousel-item.active input.card_id').val();
                var spotted_id = $('.topic_cards .carousel-item.active input.spotted_id').val();

                $.ajax({
                    url: '{{ route('spotted.add') }}',
                    data: {card_id: card_id, spotted_id: spotted_id, _token: '{{ csrf_token() }}'},
                    type: 'POST',
                    success: function (response) {
                        if (response.success != '') {
                            $('.topic_cards .carousel .navigations .spotted-btn').addClass('spotted');
                        }
                        $('.topic_cards .carousel-item.active input.spotted_id').val(response.success);
                    }
                });
            }

        });

        $('.carousel').on('slid.bs.carousel', function () {
            var spotted_id = $('.topic_cards .carousel-item.active input.spotted_id').val();
            if (spotted_id != '') {
                $('.topic_cards .carousel .navigations .spotted-btn').addClass('spotted');
            } else {
                $('.topic_cards .carousel .navigations .spotted-btn').removeClass('spotted');
            }
            var favorite_id = $('.topic_cards .carousel-item.active input.favorite_id').val();
            if (favorite_id != '') {
                $('.topic_cards .carousel .navigations .fav-btn').addClass('heart');
                $('.topic_cards .carousel .navigations .fav-btn i').addClass('fas');
                $('.topic_cards .carousel .navigations .fav-btn i').removeClass('far');
            } else {
                $('.topic_cards .carousel .navigations .fav-btn').removeClass('heart');
                $('.topic_cards .carousel .navigations .fav-btn i').addClass('far');
                $('.topic_cards .carousel .navigations .fav-btn i').removeClass('fas');
            }
            var $current = $('.topic_cards .carousel-item.active');
            var nextElem = $current.next();
            if (!nextElem.length) {
                $('.topic_cards .carousel button.right-btn').addClass('disabled');
            } else {
                $('.topic_cards .carousel button.right-btn').removeClass('disabled');
            }

            var prevElem = $current.prev();
            if (!prevElem.length) {
                $('.topic_cards .carousel button.left-btn').addClass('disabled');
            } else {
                $('.topic_cards .carousel button.left-btn').removeClass('disabled');
            }

            var spotted_count = $('.topic_cards .carousel-item.active input.spotted_count').val();
            $('.spotted-times span.spotted-count').text(spotted_count);

            var favorited_count = $('.topic_cards .carousel-item.active input.favorited_count').val();
            $('.favorited-times span.favorited-count').text(favorited_count);
        });

        $('.random-btn').on('click', function () {
            var random = Math.floor(Math.random() * Math.floor({{ $cards->count() }}));
            $('.topic_cards .carousel-inner .carousel-item').removeClass('active');
            $('.topic_cards .carousel-inner .carousel-item').eq(random).addClass('active');

            var favorite_id = $('.topic_cards .carousel-item.active input.favorite_id').val();
            if(favorite_id != ''){
                $('.topic_cards .carousel .navigations .fav-btn').addClass('heart');
                $('.topic_cards .carousel .navigations .fav-btn i').addClass('fas');
                $('.topic_cards .carousel .navigations .fav-btn i').removeClass('far');
            }else{
                $('.topic_cards .carousel .navigations .fav-btn').removeClass('heart');
                $('.topic_cards .carousel .navigations .fav-btn i').addClass('far');
                $('.topic_cards .carousel .navigations .fav-btn i').removeClass('fas');
            }
            $('button.btn.btn-dark.toggle-card').text('Show Answer');
            var spotted_count = $('.topic_cards .carousel-item.active input.spotted_count').val();
            $('.spotted-times span.spotted-count').text(spotted_count);

            var favorited_count = $('.topic_cards .carousel-item.active input.favorited_count').val();
            $('.favorited-times span.favorited-count').text(favorited_count);

        });

        $('[data-toggle="popover"]').popover()
        $('#citationModal').on('show.bs.modal', function (e) {
            $('#citationModal .modal-body').html($(e.relatedTarget).data('content'));
        });
    </script>
@endsection