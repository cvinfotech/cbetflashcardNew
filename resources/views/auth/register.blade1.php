@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Material form login -->
                <div class="card mt-5">

                    <div class="card-header theme-color white-text text-center py-4">
                        <h1 class="text-uppercase font-weight-bold">Register</h1>
                        <h4 class="">
                            <strong>Already have an account? <a href="{{ route('login') }}">Click here to
                                    login</a></strong>
                        </h4>
                    </div>

                    <!--Card content-->
                    <div class="card-body px-lg-5">

                        <!-- Form -->
                        <form class="text-center" style="color: #757575;" method="POST"
                              action="{{ route('register') }}">
                        @csrf
                        <!-- Name -->
                            <div class="md-form">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name" value="{{ old('name') }}" required autofocus placeholder="Full Name">
                                <i class="fa fa-user icon"></i>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Email -->
                            <div class="md-form">
                                <input id="materialLoginFormEmail" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                       placeholder="Email Address">
                                <i class="fa fa-envelope icon"></i>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Plan -->
                            <div class="md-form">
                                {!! Form::select('plan', getPlans(), old('plan'),
                                ['class' => 'form-control'.($errors->has('plan') ? ' is-invalid' : ''), 'placeholder' => 'Select Plan']) !!}
                                <i class="fas fa-caret-down icon"></i>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Password -->
                            <div class="md-form">
                                <input id="materialLoginFormPassword" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required autocomplete="current-password" placeholder="Password">
                                <i class="fa fa-key icon"></i>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Password -->
                            <div class="md-form">
                                <input id="password-confirm" type="password"
                                       class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                       name="password_confirmation" required placeholder="Confirm Password">
                                <i class="fa fa-key icon"></i>
                                <span class="invalid-feedback" role="alert">
                                    <strong>The password confirmation does not match.</strong>
                                </span>
                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-check">
                                <input type="checkbox"
                                       class="form-check-input {{ $errors->has('approve_terms') ? ' is-invalid' : '' }}"
                                       name="approve_terms" id="approve_terms">
                                <label class="form-check-label" for="approve_terms">I agree to the <a
                                            href="javascript:void(0)" data-toggle="modal" data-target="#termsModal">terms
                                        and conditions</a> </label>
                                @if ($errors->has('approve_terms'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('approve_terms') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Sign in button -->
                            <button class="btn btn-outline-theme btn-rounded btn-block mt-4 waves-effect z-depth-0"
                                    type="submit">Register
                            </button>

                            <img src="{{ asset('img/Paypal-Logo-2015.png') }}" class="payment-method-img mx-auto mt-2">

                        </form>
                        <!-- Form -->

                    </div>

                </div>
                <!-- Material form login -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModal"
         aria-hidden="true">

        <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2>Welcome to CBETFlashcards.com</h2>
                    <p>These terms and conditions outline the rules and regulations for the use of CBETFlashcards.com's
                        Website.</p> <br/> <span style="text-transform: capitalize;"> CBETFlashcards.com</span> is located
                    at:<br/>
                    <address><br/></address>
                    <p>By accessing this website we assume you accept these terms and conditions in full. Do not continue to
                        use CBETFlashcards.com's website if you do not accept all of the terms and conditions stated on this
                        page.</p>
                    <p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer
                        Notice and any or all Agreements: "Client", "You" and "Your" refers to you, the person accessing
                        this website and accepting the Company's terms and conditions. "The Company", "Ourselves", "We",
                        "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and
                        ourselves, or either the Client or ourselves. All terms refer to the offer, acceptance and
                        consideration of payment necessary to undertake the process of our assistance to the Client in the
                        most appropriate manner, whether by formal meetings of a fixed duration, or any other means, for the
                        express purpose of meeting the Client's needs in respect of provision of the Company's stated
                        services/products, in accordance with and subject to, prevailing law of . Any use of the above
                        terminology or other words in the singular, plural, capitalisation and/or he/she or they, are taken
                        as interchangeable and therefore as referring to same.</p>
                    <h2>Cookies</h2>
                    <p>We employ the use of cookies. By using CBETFlashcards.com's website you consent to the use of cookies
                        in accordance with CBETFlashcards.com's privacy policy.</p>
                    <p>Most of the modern day interactive web sites use cookies to enable us to retrieve user details for
                        each visit. Cookies are used in some areas of our site to enable the functionality of this area and
                        ease of use for those people visiting. Some of our affiliate / advertising partners may also use
                        cookies.</p>
                    <h2>License</h2>
                    <p>Unless otherwise stated, CBETFlashcards.com and/or it's licensors own the intellectual property
                        rights for all material on CBETFlashcards.com. All intellectual property rights are reserved. You
                        may view and/or print pages from http://www.cbetflashcards.com for your own personal use subject to
                        restrictions set in these terms and conditions.</p>
                    <p>You must not:</p>
                    <ol>
                        <li>Republish material from http://www.cbetflashcards.com</li>
                        <li>Sell, rent or sub-license material from http://www.cbetflashcards.com</li>
                        <li>Reproduce, duplicate or copy material from http://www.cbetflashcards.com</li>
                    </ol>
                    <p>Redistribute content from CBETFlashcards.com (unless content is specifically made for
                        redistribution).</p>
                    <h2>Hyperlinking to our Content</h2>
                    <ol>
                        <li>The following organizations may link to our Web site without prior written approval:
                            <ol>
                                <li>Government agencies;</li>
                                <li>Search engines;</li>
                                <li>News organizations;</li>
                                <li>Online directory distributors when they list us in the directory may link to our Web
                                    site in the same manner as they hyperlink to the Web sites of other listed businesses;
                                    and
                                </li>
                                <li>Systemwide Accredited Businesses except soliciting non-profit organizations, charity
                                    shopping malls, and charity fundraising groups which may not hyperlink to our Web site.
                                </li>
                            </ol>
                        </li>
                    </ol>
                    <ol start="2">
                        <li>These organizations may link to our home page, to publications or to other Web site information
                            so long as the link: (a) is not in any way misleading; (b) does not falsely imply sponsorship,
                            endorsement or approval of the linking party and its products or services; and (c) fits within
                            the context of the linking party's site.
                        </li>
                        <li>We may consider and approve in our sole discretion other link requests from the following types
                            of organizations:
                            <ol>
                                <li>commonly-known consumer and/or business information sources such as Chambers of
                                    Commerce, American Automobile Association, AARP and Consumers Union;
                                </li>
                                <li>dot.com community sites;</li>
                                <li>associations or other groups representing charities, including charity giving sites,
                                </li>
                                <li>online directory distributors;</li>
                                <li>internet portals;</li>
                                <li>accounting, law and consulting firms whose primary clients are businesses; and</li>
                                <li>educational institutions and trade associations.</li>
                            </ol>
                        </li>
                    </ol>
                    <p>We will approve link requests from these organizations if we determine that: (a) the link would not
                        reflect unfavorably on us or our accredited businesses (for example, trade associations or other
                        organizations representing inherently suspect types of business, such as work-at-home opportunities,
                        shall not be allowed to link); (b)the organization does not have an unsatisfactory record with us;
                        (c) the benefit to us from the visibility associated with the hyperlink outweighs the absence
                        of {{ env('APP_NAME') }}; and (d) where the link is in the context of general resource information or is
                        otherwise consistent with editorial content in a newsletter or similar product furthering the
                        mission of the organization.</p>
                    <p>These organizations may link to our home page, to publications or to other Web site information so
                        long as the link: (a) is not in any way misleading; (b) does not falsely imply sponsorship,
                        endorsement or approval of the linking party and it products or services; and (c) fits within the
                        context of the linking party's site.</p>
                    <p>If you are among the organizations listed in paragraph 2 above and are interested in linking to our
                        website, you must notify us by sending an e-mail to <a href="mailto:team@cbetflashcards.com"
                                                                               title="send an email to team@cbetflashcards.com">team@cbetflashcards.com</a>.
                        Please include your name, your organization name, contact information (such as a phone number and/or
                        e-mail address) as well as the URL of your site, a list of any URLs from which you intend to link to
                        our Web site, and a list of the URL(s) on our site to which you would like to link. Allow 2-3 weeks
                        for a response.</p>
                    <p>Approved organizations may hyperlink to our Web site as follows:</p>
                    <ol>
                        <li>By use of our corporate name; or</li>
                        <li>By use of the uniform resource locator (Web address) being linked to; or</li>
                        <li>By use of any other description of our Web site or material being linked to that makes sense
                            within the context and format of content on the linking party's site.
                        </li>
                    </ol>
                    <p>No use of CBETFlashcards.com's logo or other artwork will be allowed for linking absent a trademark
                        license agreement.</p>
                    <h2>Iframes</h2>
                    <p>Without prior approval and express written permission, you may not create frames around our Web pages
                        or use other techniques that alter in any way the visual presentation or appearance of our Web
                        site.</p>
                    <h2>Reservation of Rights</h2>
                    <p>We reserve the right at any time and in its sole discretion to request that you remove all links or
                        any particular link to our Web site. You agree to immediately remove all links to our Web site upon
                        such request. We also reserve the right to amend these terms and conditions and its linking policy
                        at any time. By continuing to link to our Web site, you agree to be bound to and abide by these
                        linking terms and conditions.</p>
                    <h2>Removal of links from our website</h2>
                    <p>If you find any link on our Web site or any linked web site objectionable for any reason, you may
                        contact us about this. We will consider requests to remove links but will have no obligation to do
                        so or to respond directly to you.</p>
                    <p>Whilst we endeavour to ensure that the information on this website is correct, we do not warrant its
                        completeness or accuracy; nor do we commit to ensuring that the website remains available or that
                        the material on the website is kept up to date.</p>
                    <h2>Content Liability</h2>
                    <p>We shall have no responsibility or liability for any content appearing on your Web site. You agree to
                        indemnify and defend us against all claims arising out of or based upon your Website. No link(s) may
                        appear on any page on your Web site or within any context containing content or materials that may
                        be interpreted as libelous, obscene or criminal, or which infringes, otherwise violates, or
                        advocates the infringement or other violation of, any third party rights.</p>
                    <h2>Disclaimer</h2>
                    <p>To the maximum extent permitted by applicable law, we exclude all representations, warranties and
                        conditions relating to our website and the use of this website (including, without limitation, any
                        warranties implied by law in respect of satisfactory quality, fitness for purpose and/or the use of
                        reasonable care and skill). Nothing in this disclaimer will:</p>
                    <ol>
                        <li>limit or exclude our or your liability for death or personal injury resulting from negligence;
                        </li>
                        <li>limit or exclude our or your liability for fraud or fraudulent misrepresentation;</li>
                        <li>limit any of our or your liabilities in any way that is not permitted under applicable law; or
                        </li>
                        <li>exclude any of our or your liabilities that may not be excluded under applicable law.</li>
                    </ol>
                    <p>The limitations and exclusions of liability set out in this Section and elsewhere in this disclaimer:
                        (a) are subject to the preceding paragraph; and (b) govern all liabilities arising under the
                        disclaimer or in relation to the subject matter of this disclaimer, including liabilities arising in
                        contract, in tort (including negligence) and for breach of statutory duty.</p>
                    <p>To the extent that the website and the information and services on the website are provided free of
                        charge, we will not be liable for any loss or damage of any nature.</p>
                    <h2></h2>
                    <p></p>
                    <h2>Credit & Contact Information</h2>
                    <p>This Terms and conditions page was created at <a
                                style="color:inherit;text-decoration:none;cursor:text;"
                                href="https://termsandconditionstemplate.com" target="_blank">termsandconditionstemplate.com</a> generator.
                        If you have any queries regarding any of our terms, please contact us.</p>


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
        $('input#password-confirm').on('keyup', function(){
            if($('input#password-confirm').val() != $('input#materialLoginFormPassword').val()){
                $('input#password-confirm').addClass('is-invalid');
            }else{
                $('input#password-confirm').removeClass('is-invalid');
            }
        });

    </script>
@endsection