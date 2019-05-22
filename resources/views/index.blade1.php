<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CBET Flash Cards</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <title>@yield('title')</title>
    <!-- Favicons -->
    <link href="img/favicon.png" rel="icon">
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Ruda:400,900,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">


    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="lib/prettyphoto/css/prettyphoto.css" rel="stylesheet">
    <link href="lib/hover/hoverex-all.css" rel="stylesheet">
    <link href="lib/jetmenu/jetmenu.css" rel="stylesheet">
    <link href="lib/owl-carousel/owl-carousel.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="css/colors/blue.css">

</head>

<body>

<!-- end header -->
<header class="header">
    <div class="container">
        <div class="site-header clearfix">
            <div class="col-lg-3 col-md-3 col-sm-12 title-area">
                <div class="site-title" id="title">
                    <a href="#" title="">
                        <img src="img/logo1.png">
                    </a>
                </div>
            </div>
            <!-- title area -->
            <div class="col-lg-9 col-md-12 col-sm-12">
                <div id="nav" class="right">
                    <div class="container clearfix">
                        <ul id="jetmenu" class="jetmenu blue">
                            <li class="active"><a href="index.html">Home</a></li>
                            <li><a href="#price_table">Pricing</a></li>
                            <li><a href="#features">Features</a></li>
                            <li><a href="#contact">Contact Us</a></li>
                            @guest
                                <li><a href="{{ route('login') }}">Log in</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @else
                                <li class="dashboard">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Hi, {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>


                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <ul>
                                            @if(isset(Auth::user()->user_type) && Auth::user()->user_type == 'admin')
                                                <li><a href="{{ route('home') }}" class="dropdown-item">Dashboard</a>
                                                </li>
                                            @else
                                                <li><a href="{{ route('home') }}" class="dropdown-item">Flashcards</a>
                                                </li>
                                            @endif
                                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                      style="display: none;">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endguest

                        </ul>
                    </div>
                </div>
                <!-- nav -->
            </div>
            <!-- title area -->
        </div>
        <!-- site header -->
    </div>
    <!-- end container -->
</header>
<section id="intro">
    <div class="container">
        <div class="ror">
            <div class="col-md-8 col-md-offset-2">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ __(session('success')) }}
                    </div>
                @endif
                <div class="headings">
                    <h1><span>Welcome to </span><br/> CBET FLASHCARDS</h1>
                    <h2 class="sub-title">The most convenient way to review high yield material for the CBET Exam</h2>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="section1" id="features">
    <div class="container">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="servicebox text-center">
                <div class="service-icon">
                    <div class="dm-icon-effect-1" data-effect="slide-left">
                        <a href="#" class="">
                            <i class="active dm-icon fa fa-clock-o fa-3x"></i> </a>
                    </div>
                    <div class="servicetitle">
                        <h4>Up To Date</h4>
                        <h5><b>Always Accurate</b></h5>
                        <hr>
                    </div>
                    <p>We take out time making sure the flashcards are current and accurate and reflect questions you
                        might see on the actual exam. We also regularly add more questions to our questions banks.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="servicebox text-center">
                <div class="service-icon">
                    <div class="dm-icon-effect-1" data-effect="slide-bottom">
                        <a href="#" class=""> <i class="active dm-icon fa fa-star fa-3x"></i> </a>
                    </div>
                    <div class="servicetitle">
                        <h4>High Yield Content</h4>
                        <h5><b>Focus On What Matters</b></h5>
                        <hr>
                    </div>
                    <p>Don't spend time learning things that aren't relevant to the exam. Focus most of your energy on
                        the hight yield content and your chances of passing will increase.</p>
                </div>
                <!-- service-icon -->
            </div>
            <!-- servicebox -->
        </div>


        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="servicebox text-center">
                <div class="service-icon">
                    <div class="dm-icon-effect-1" data-effect="slide-right">
                        <a href="#" class=""> <i class="active dm-icon fa fa-mobile fa-3x"></i> </a>
                    </div>
                    <div class="servicetitle">
                        <h4>Mobile Ready</h4>
                        <h5><b>Study On The Go</b></h5>
                        <hr>
                    </div>
                    <p>Get your study time in during your commute to work, on any device that has internet access. Study
                        on your desktop, mobile phone or tablet.</p>
                </div>
                <!-- service-icon -->
            </div>
            <!-- servicebox -->
        </div>
        <!-- large-4 -->
    </div>
    <!-- end container -->
</section>

<section class="section1 text-center" id="price_table">
    <div class="container">
        <div class="general-title">{{--
        <h3>AFFORDABLE PRICES</h3>--}}
        </div>
        <div class="row ss_pricing">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" data-effect="slide-bottom">
                <div class="custom-box">
                    <!--  <div class="servicetitle">
                      <h4>Standard</h4>
                       <hr>
                     </div>-->
                    <div class="icn-main-container">
                        <span class="icn-container">$45</span>
                        <span class="icn-container sub">/ 3 Months Access</span>

                    </div>
                    <ul class="pricing">
                        <li>Best value for study material in the market</li>
                        <li>Access to all question banks</li>
                        <li>Create unlimited custom cards</li>
                        <li>See questions spotted on the test</li>
                    </ul>
                    <a class="btn btn-primary" href="{{ route('register') }}">SIGN UP</a>
                </div>
                <!-- end custombox -->
            </div>
            <!-- end col-4 -->

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" data-effect="slide-bottom">
                <div class="custom-box">
                    <div class="servicetitle">
                    </div>
                    <div class="icn-main-container">
                        <span class="icn-container">$80</span>
                        <span class="icn-container sub">/ 6 Months Access</span>
                    </div>
                    <ul class="pricing">
                        <li>Save 6.25% by purchasing 6 months access</li>
                        <li>Access to all question banks</li>
                        <li>Create unlimited custom cards</li>
                        <li>See questions spotted on the test</li>
                    </ul>
                    <a class="btn btn-primary" href="{{ route('register') }}">SIGN UP</a>
                </div>
                <!-- end custombox -->
            </div>
            <!-- end col-4 -->

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" data-effect="slide-bottom">
                <div class="custom-box">
                    <div class="servicetitle">

                    </div>
                    <div class="icn-main-container">
                        <div class="banner-container">
                            <div class="banner">Best Seller</div>
                        </div>
                        <span class="icn-container">$120</span>
                        <span class="icn-container sub">/ Yearly</span>
                    </div>
                    <ul class="pricing">
                        <li>Save 14.29% by purchasing the yearly access</li>
                        <li>Access to all question banks</li>
                        <li>Create unlimited questions cards</li>
                        <li>See questions spotted on the test</li>
                    </ul>
                    <a class="btn btn-primary" href="{{ route('register') }}">SIGN UP</a>
                </div>
                <!-- end custombox -->
            </div>
            <!-- end col-4 -->

        </div>
    </div>
    <!-- end container -->
</section>
<!-- end section1 -->
<section class="section5">
    <div class="container">
        <div class="col-lg-6 col-md-6 col-sm-12 columns">

            <div class="textcolor">
                <p>With 1,000+ question cards available to view instantly, there's no better way to get ready for the
                    CBET Exam. We are constantly adding questions and reviewing our content to make sure it's exactly
                    what you need to be learning to pass the test!</p>
            </div>
            <!-- <div class="widget" data-effect="slide-left">
               <img src="img/slider_02.png" alt="">
             </div>-->
            <!-- end widget -->
        </div>
        <!-- large-6 -->
        <div class="col-lg-6 col-md-6 col-sm-12 columns">
            <div class="widget clearfix">
                <div class="services_lists">
                    <img src="img/graph.jpg">
                </div>
                <!-- services_lists -->
            </div>
            <!-- end widget -->
        </div>
        <!-- large-6 -->
    </div>
    <!-- end container -->
</section>


<section class="section3">
    <div class="container">
        <div class="message">
            <div class="col-lg-9 col-md-9 col-sm-9">
                <h3>GET ACCESS TO ALL THE <br/>FLASH CARDS Now!!</h3>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <a class="dmbutton button large pull-left" href="{{ route('register') }}">Sign Up</a>
            </div>
        </div>
        <!-- end message -->
    </div>
    <!-- end container -->
</section>
<!-- end section3 -->
<section id="contact" class="section1 contact">
    <div class="container clearfix">
        <div class="content col-lg-12 col-md-12 col-sm-12 clearfix">
            <div class="col-lg-6 col-md-6 col-sm-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="contact-form">
                    {!! Form::open(['route' => 'contact', 'method' => 'post']) !!}

                    <div class="form-group">
                        {!! Form::label('name', 'name') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('email', 'email') !!}
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('phone', 'phone') !!}
                        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('message1', 'message') !!}
                        {!! Form::textarea('message1', null, ['class' => 'form-control' , 'placeholder'=>'Please write something for us']) !!}
                    </div>
                    <div class="form-send">
                        {!! Form::submit('Submit', ['class' => 'button btn btn-large btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>

                {{--           <form class="contact-form php-mail-form" role="form" action="" method="POST">

                                    <div class="form-group">
                                        <input type="name" name="name" class="form-control" id="contact-name" placeholder="Name*" data-rule="minlen:4" data-msg="Please enter at least 4 chars" >
                                        <div class="validate"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" id="contact-email" placeholder="Email*" data-rule="email" data-msg="Please enter a valid email">
                                        <div class="validate"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="subject" class="form-control" id="contact-subject" placeholder="Phone Number" data-rule="minlen:4" data-msg="Please enter a valid Number">
                                        <div class="validate"></div>
                                    </div>

                                    <div class="form-group">
                                        <textarea class="form-control" name="message" id="contact-message" placeholder="" rows="5" data-rule="required" data-msg="Please write something for us"></textarea>
                                        <div class="validate"></div>
                                    </div>

                                    <div class="loading"></div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>

                                    <div class="form-send">
                                        <button type="submit" class="btn btn-large btn-primary">Submit Now</button>
                                    </div>

                                </form>--}}
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <h1>Contact Us</h1>
                <div class="social_cons">
                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="facebook"><img
                                src="img/facebook.png"></a>
                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="linkedin"><img
                                src="img/in.png"></a>
                </div>
                <p>Please leave us a message here and we will get back to you as quickly as possible. We strive to
                    deliver an excellent product to our customers so please do not hesitate to send us a message with
                    any questions or concerns. </p>
                <ul class="contact_details">
                    <br/>
                    <p>Support email: team@cbetflashcards.com</p>
                    <p>Address: New York, NY</p>
                </ul>
                <!-- contact_details -->
            </div>

        </div>
    </div>
    <!-- end container -->
</section>


<footer class="footer">
    <div class="container">
        <div class="widget col-lg-4 col-md-4 col-sm-12">
            <img src="img/logo1.png">
            <p>From the creator of iCBET and CBET Test Prep, we bring you this new project which is a the next iteration
                of the initial CBET flashcards project.</p>
        </div>
        <!-- end widget -->

        <div class="widget col-lg-4 col-md-4 col-sm-12 text-center">
            <h4><span>Recent Posts</span></h4>
            <ul class="contact_details">
                <br/>
                <li><a href="#price_table">Pricing</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#contact">Contact Us</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            </ul>
            <!-- contact_details -->
        </div>
        <!-- end widget -->
        <div class="widget col-lg-4 col-md-4 col-sm-12 text-center">
            <h4><span>Connect with us</span></h4>
            <br/>
            <a href="#" data-toggle="tooltip" data-placement="bottom" title="facebook"><img
                        src="img/facebook-hover.png"></a>
            <a href="#" data-toggle="tooltip" data-placement="bottom" title="linkedin"><img src="img/in-hover.png"></a>

        </div>
        <!-- end widget -->
    </div>
    <!-- end container -->

    <div class="copyrights">
        <div class="container">
            <div class="col-lg-6 col-md-6 col-sm-12 columns footer-left">
            </div>
            <!-- end widget -->
            <div class="col-lg-6 col-md-6 col-sm-12 columns text-right">
                <div class="footer-menu right">
                    <ul class="menu">
                        <li><a href="javascript:void(0);" class="goTop">Top</a></li>
                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#privacyModal">Privacy</a>
                        </li>
                        <li><a href="{{ asset('img/sitemap.xml') }}" target="_blank">Sitemap</a></li>
                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#termsModal">Site Terms</a>
                        </li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
            <!-- end large-6 -->
        </div>
        <!-- end container -->
    </div>
    <!-- end copyrights -->
</footer>

<!-- Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="privacyModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="privacyModalTitle">Privacy</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1>Welcome to our Privacy Policy</h1>
                <h3>Your privacy is critically important to us.</h3> CBETFlashcards.com is located at:<br/>
                <address> CBETFlashcards.com<br/><br/>6462473451</address>
                <p>It is CBETFlashcards.com's policy to respect your privacy regarding any information we may collect
                    while operating our website. This Privacy Policy applies to <a href="http://www.cbetflashcards.com">www.cbetflashcards.com</a>
                    (hereinafter, "us", "we", or "www.cbetflashcards.com"). We respect your privacy and are committed to
                    protecting personally identifiable information you may provide us through the Website. We have
                    adopted this privacy policy ("Privacy Policy") to explain what information may be collected on our
                    Website, how we use this information, and under what circumstances we may disclose the information
                    to third parties. This Privacy Policy applies only to information we collect through the Website and
                    does not apply to our collection of information from other sources.</p>
                <p>This Privacy Policy, together with the Terms and conditions posted on our Website, set forth the
                    general rules and policies governing your use of our Website. Depending on your activities when
                    visiting our Website, you may be required to agree to additional terms and conditions.</p>
                <h2>Website Visitors</h2>
                <p>Like most website operators, CBETFlashcards.com collects non- personally-identifying information of
                    the sort that web browsers and servers typically make available, such as the browser type, language
                    preference, referring site, and the date and time of each visitor request. CBETFlashcards.com's
                    purpose in collecting non-personally identifying information is to better understand how
                    CBETFlashcards.com's visitors use its website. From time to time, CBETFlashcards.com may release
                    non-personally-identifying information in the aggregate, e.g., by publishing a report on trends in
                    the usage of its website.</p>
                <p>CBETFlashcards.com also collects potentially personally-identifying information like Internet
                    Protocol (IP) addresses for logged in users and for users leaving comments on
                    http://www.cbetflashcards.com blog posts. CBETFlashcards.com only discloses logged in user and
                    commenter IP addresses under the same circumstances that it uses and discloses
                    personally-identifying information as described below.</p>
                <h2>Gathering of Personally-Identifying Information</h2>
                <p>Certain visitors to CBETFlashcards.com's websites choose to interact with CBETFlashcards.com in ways
                    that require CBETFlashcards.com to gather personally- identifying information. The amount and type
                    of information that CBETFlashcards.com gathers depends on the nature of the interaction. For
                    example, we ask visitors who sign up for a blog at http://www.cbetflashcards.com to provide a
                    username and email address.</p>
                <h2>Security</h2>
                <p>The security of your Personal Information is important to us, but remember that no method of
                    transmission over the Internet, or method of electronic storage is 100% secure. While we strive to
                    use commercially acceptable means to protect your Personal Information, we cannot guarantee its
                    absolute security.</p>
                <h2>Advertisements</h2>
                <p>Ads appearing on our website may be delivered to users by advertising partners, who may set cookies.
                    These cookies allow the ad server to recognize your computer each time they send you an online
                    advertisement to compile information about you or others who use your computer. This information
                    allows ad networks to, among other things, deliver targeted advertisements that they believe will be
                    of most interest to you. This Privacy Policy covers the use of cookies by CBETFlashcards.com and
                    does not cover the use of cookies by any advertisers.</p>
                <h2>Links To External Sites</h2>
                <p>Our Service may contain links to external sites that are not operated by us. If you click on a third
                    party link, you will be directed to that third party's site. We strongly advise you to review the
                    Privacy Policy and terms and conditions of every site you visit.</p>
                <p>We have no control over, and assume no responsibility for the content, privacy policies or practices
                    of any third party sites, products or services.</p>
                <h2>Protection of Certain Personally-Identifying Information</h2>
                <p>CBETFlashcards.com discloses potentially personally-identifying and personally-identifying
                    information only to those of its employees, contractors and affiliated organizations that (i) need
                    to know that information in order to process it on CBETFlashcards.com's behalf or to provide
                    services available at CBETFlashcards.com's website, and (ii) that have agreed not to disclose it to
                    others. Some of those employees, contractors and affiliated organizations may be located outside of
                    your home country; by using CBETFlashcards.com's website, you consent to the transfer of such
                    information to them. CBETFlashcards.com will not rent or sell potentially personally-identifying and
                    personally- identifying information to anyone. Other than to its employees, contractors and
                    affiliated organizations, as described above, CBETFlashcards.com discloses potentially personally-
                    identifying and personally-identifying information only in response to a subpoena, court order or
                    other governmental request, or when CBETFlashcards.com believes in good faith that disclosure is
                    reasonably necessary to protect the property or rights of CBETFlashcards.com, third parties or the
                    public at large.</p>
                <p>If you are a registered user of http://www.cbetflashcards.com and have supplied your email address,
                    CBETFlashcards.com may occasionally send you an email to tell you about new features, solicit your
                    feedback, or just keep you up to date with what's going on with CBETFlashcards.com and our products.
                    We primarily use our blog to communicate this type of information, so we expect to keep this type of
                    email to a minimum. If you send us a request (for example via a support email or via one of our
                    feedback mechanisms), we reserve the right to publish it in order to help us clarify or respond to
                    your request or to help us support other users. CBETFlashcards.com takes all measures reasonably
                    necessary to protect against the unauthorized access, use, alteration or destruction of potentially
                    personally-identifying and personally-identifying information.</p>
                <h2>Aggregated Statistics</h2>
                <p>CBETFlashcards.com may collect statistics about the behavior of visitors to its website.
                    CBETFlashcards.com may display this information publicly or provide it to others. However,
                    CBETFlashcards.com does not disclose your personally-identifying information.</p>
                <h2>Cookies</h2>
                <p>To enrich and perfect your online experience, CBETFlashcards.com uses "Cookies", similar technologies
                    and services provided by others to display personalized content, appropriate advertising and store
                    your preferences on your computer.</p>
                <p>A cookie is a string of information that a website stores on a visitor's computer, and that the
                    visitor's browser provides to the website each time the visitor returns. CBETFlashcards.com uses
                    cookies to help CBETFlashcards.com identify and track visitors, their usage of
                    http://www.cbetflashcards.com, and their website access preferences. CBETFlashcards.com visitors who
                    do not wish to have cookies placed on their computers should set their browsers to refuse cookies
                    before using CBETFlashcards.com's websites, with the drawback that certain features of
                    CBETFlashcards.com's websites may not function properly without the aid of cookies.</p>
                <p>By continuing to navigate our website without changing your cookie settings, you hereby acknowledge
                    and agree to CBETFlashcards.com's use of cookies.</p>
                <h2>Privacy Policy Changes</h2>
                <p>Although most changes are likely to be minor, CBETFlashcards.com may change its Privacy Policy from
                    time to time, and in CBETFlashcards.com's sole discretion. CBETFlashcards.com encourages visitors to
                    frequently check this page for any changes to its Privacy Policy. Your continued use of this site
                    after any change in this Privacy Policy will constitute your acceptance of such change.</p>
                <h2></h2>
                <p></p>
                <h2>Credit & Contact Information</h2>
                <p>This privacy policy was created at <a style="color:inherit;text-decoration:none;"
                                                         href="https://termsandconditionstemplate.com/privacy-policy-generator/"
                                                         title="Privacy policy template generator" target="_blank">termsandconditionstemplate.com</a>.
                    If you have any questions about this Privacy Policy, please contact us via <a
                            href="mailto:team@cbetflashcards.com">email</a> or <a href="tel:6462473451">phone</a>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="termsModalTitle">Terms and Conditions</h2>
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
                    of {{ env('APP_NAME') }}; and (d) where the link is in the context of general resource information
                    or is
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
<!-- end footer -->
<div class="dmtop">Scroll to Top</div>

<!-- JavaScript Libraries -->
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>
<script src="lib/prettyphoto/js/prettyphoto.js"></script>
<script src="lib/isotope/isotope.min.js"></script>
<script src="lib/hover/hoverdir.js"></script>
<script src="lib/hover/hoverex.min.js"></script>
<script src="lib/unveil-effects/unveil-effects.js"></script>
<script src="lib/jetmenu/jetmenu.js"></script>
<script src="lib/animate-enhanced/animate-enhanced.min.js"></script>
<script src="lib/easypiechart/easypiechart.min.js"></script>

<!-- Template Main Javascript File -->
<script src="js/main.js"></script>
<script>
    $(document).ready(function () {
        // Add smooth scrolling to all links
        $("a").on('click', function (event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 1500, function () {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });
    });
</script>

</body>
</html>
