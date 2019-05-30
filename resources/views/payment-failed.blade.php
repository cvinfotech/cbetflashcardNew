@extends('layouts.app')
@section('styles')
    <style>
        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;

            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
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
            {!! Form::open(['route' => 'change.plan', 'method' => 'POST', 'id' => 'payment-form']) !!}
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
                    <!-- Plan -->
                    <div class="md-form">
                        {!! Form::select('payment_method', ['paypal' => "PayPal", 'stripe' => 'Stripe'], old('paymet_method'),
                        ['id' => 'payment_method', 'required' => 'required', 'class' => 'form-control'.($errors->has('payment_method') ? ' is-invalid' : ''), 'placeholder' => 'Select Payment method']) !!}
                        <i class="fas fa-caret-down icon"></i>
                        @if ($errors->has('payment_method'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('payment_method') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="md-form stripe hide">
                        <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
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
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).on('change', 'select#payment_method', function () {
            if($(this).val() == 'stripe'){
                $('.md-form.stripe').show();
            }else{
                $('.md-form.stripe').hide();
            }
        })


        // Create a Stripe client.
        var stripe = Stripe('pk_test_uFSAJPThEm2F5tJZlRbhfOeL');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            if($('#card-element:visible').length) {
                event.preventDefault();

                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            }
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

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