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
                                    <div class="questtions-label page-heading">Payment </div>
                                    <div class="topic_cards">


                                            <div class="alert alert-danger" role="alert">
                                                You cannot access your account. Please pay to continue.
                                                <a href="javascript:void(0)"  data-toggle="modal" data-target="#changePlanModal"><img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png" alt="Check out with PayPal" /></a>
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
    <!-- Modal -->
    <div class="modal fade" id="changePlanModal" tabindex="-1" role="dialog" aria-labelledby="changePlanModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => 'change.plan', 'method' => 'POST']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePlanModalLable">Select a plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Plan -->
                    <div class="md-form">
                        {!! Form::select('plan', getPlans(), '', ['class' => 'form-control']) !!}
                        <i class="fas fa-caret-down icon"></i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Submit</button>
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
            loop:false
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
        $('.topic_cards .carousel .navigations .fav-btn').on('click', function () {
            var card_id = $('.topic_cards .carousel-item.active input.card_id').val();
            var favorite_id = $('.topic_cards .carousel-item.active input.favorite_id').val();

            $.ajax({
                url: '{{ route('favorite.toggle') }}',
                data: {card_id: card_id, favorite_id: favorite_id, _token: '{{ csrf_token() }}'},
                type: 'POST',
                success: function (response) {
                    if(response.success != ''){
                        $('.topic_cards .carousel .navigations .fav-btn').addClass('heart');
                        $('.topic_cards .carousel .navigations .fav-btn i').addClass('fas');
                        $('.topic_cards .carousel .navigations .fav-btn i').removeClass('far');
                    }else{
                        $('.topic_cards .carousel .navigations .fav-btn').removeClass('heart');
                        $('.topic_cards .carousel .navigations .fav-btn i').addClass('far');
                        $('.topic_cards .carousel .navigations .fav-btn i').removeClass('fas');
                    }
                    $('.topic_cards .carousel-item.active input.favorite_id').val(response.success);
                }
            });

        })

        $('.carousel').on('slid.bs.carousel', function () {
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
        })
    </script>
@endsection