@extends('landing.base')

@section('title', 'Home - ForteScrum')

@section('content')

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('landing/img/logo.png') }}" alt="">
            <span>{{ config('app.name') }}</span>
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#feature">Features</a></li>
                <li><a class="nav-link scrollto" href="#faq">Frequently Asked Questions</a></li>

                @if(Auth::guest())
                <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li><a class="getstarted" href="{{ route('register') }}">Sign Up</a></li>
                @else
                <li class="dropdown">
                    <a href="#"><span>{{ Auth::user()->name }} - {{ Auth::user()->currentTeam->name }}</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('profile.show') }}">Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">Logout</a>
                            </form>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center">
                <h1 data-aos="fade-up">We offer modern solutions for project management</h1>
                <h2 data-aos="fade-up" data-aos-delay="400">Manage your software project with ease by utilizing the SCRUM framework</h2>
                <div data-aos="fade-up" data-aos-delay="600">
                    <div class="text-center text-lg-start">
                        <a href="{{ route('project.index') }}"
                            class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                            <span>Create A New Project</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <img src="{{ asset('landing/img/hero-img.png') }}" class="img-fluid" alt="">
                {{-- <br><span>Image by <a href="https://bootstrapmade.com/">BoostrapMade</a></span> --}}
            </div>
        </div>
    </div>

</section><!-- End Hero -->

<main id="main">

    <!-- ======= Values Section ======= -->
    <section id="feature" class="values">

        <div class="container" data-aos="fade-up">

            <header class="section-header">
                <h2>Features</h2>
                <p>Some amazing features you can use</p>
            </header>

            <div class="row">

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="box">
                        <img src="{{ asset('landing/img/values-1.png') }}" class="img-fluid" alt="">
                        <h3>Easily manage your projects</h3>
                        <p>Plan sprint and backlog using tools avalaible in this app.</p>
                    </div>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400">
                    <div class="box">
                        <img src="{{ asset('landing/img/values-2.png') }}" class="img-fluid" alt="">
                        <h3>Boost your productivity</h3>
                        <p>Allocate, set, and notify tasks for every team member with ease.</p>
                    </div>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="600">
                    <div class="box">
                        <img src="{{ asset('landing/img/values-3.png') }}" class="img-fluid" alt="">
                        <h3>Record your worktime</h3>
                        <p>Record timesheet for all of your tasks in your project.</p>
                    </div>
                </div>

            </div>

        </div>

    </section><!-- End Values Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
        <div class="container" data-aos="fade-up">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="bi bi-emoji-smile"></i>
                        <div>
                            <span data-purecounter-start="0" data-purecounter-end="{{ count($client) }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Happy Clients</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="bi bi-journal-richtext" style="color: #ee6c20;"></i>
                        <div>
                            <span data-purecounter-start="0" data-purecounter-end="{{ count($project) }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Projects</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="bi bi-clock" style="color: #15be56;"></i>
                        <div>
                            <span data-purecounter-start="0" data-purecounter-end="{{ $total_hour }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Hours Worked</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="bi bi-people" style="color: #bb0852;"></i>
                        <div>
                            <span data-purecounter-start="0" data-purecounter-end="{{ count($user) }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Hard Workers</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Counts Section -->

    <!-- ======= F.A.Q Section ======= -->
    <section id="faq" class="faq">

        <div class="container" data-aos="fade-up">

            <header class="section-header">
                <h2>F.A.Q</h2>
                <p>Frequently Asked Questions</p>
            </header>

            <div class="row">
                <div class="col-lg-6">
                    <!-- F.A.Q List 1-->
                    <div class="accordion accordion-flush" id="faqlist1">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-content-1">
                                    How to use the app?
                                </button>
                            </h2>
                            <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                <div class="accordion-body">
                                    First you need to register an account either as a project manager or regular user, then
                                    you can start using the app by logging in to the system and utilize all the avalaible tools.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-content-2">
                                    How can I change my role in a project?
                                </button>
                            </h2>
                            <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                <div class="accordion-body">
                                    You need to ask project manager to change your role from guest/regular user to your
                                    designated roles like product owner or team member.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-content-3">
                                    How many client a single team can have?
                                </button>
                            </h2>
                            <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                <div class="accordion-body">
                                    A single team can only handle one client, this is applied to avoid confusion between project
                                    so that a team can only focus on finishing the requirement from project that come with those client.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">

                    <!-- F.A.Q List 2-->
                    <div class="accordion accordion-flush" id="faqlist2">

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2-content-1">
                                    Can a single client have more than one project?
                                </button>
                            </h2>
                            <div id="faq2-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                <div class="accordion-body">
                                    Yes they can. A single team can have multiple projects with the same client.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2-content-2">
                                    How can I record my worktime?
                                </button>
                            </h2>
                            <div id="faq2-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                <div class="accordion-body">
                                    First you need to create a task, then there is an option called "Record Worktime" if 
                                    you click on those tasks. After that you will be redirected to record worktime form.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2-content-3">
                                    How to use the invoicing feature?
                                </button>
                            </h2>
                            <div id="faq2-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                <div class="accordion-body">
                                    After you created a few tasks/expenses/timesheets in a project, you can create an invoice 
                                    related to those project by navigating to the manage invoice section on the sidebar. There 
                                    you can choose whichever unit you want to add to your invoice or add discount/tax to those
                                    invoice.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </section><!-- End F.A.Q Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">

    <div class="footer-top">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-info">
                    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                        <img src="{{ asset('landing/img/logo.png') }}" alt="">
                        <span>{{ config('app.name') }}</span>
                    </a>
                    <p>
                        Modern solution to your software project management needs, 
                        by utilizing the SCRUM framework.
                    </p>
                    <div class="social-links mt-3">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6 footer-links mb-0 pb-0 mt-0 pt-0"></div>
                <div class="col-lg-2 col-6 footer-links mb-0 pb-0 mt-0 pt-0"></div>

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Contact Us</h4>
                    <p>
                        Tegal Wangi III Street <br>
                        Denpasar, Bali<br>
                        Indonesia <br><br>
                        <strong>Phone:</strong> +62 882 1922 6704<br>
                        <strong>Email:</strong> info@fortescrum.com<br>
                    </p>

                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            Copyright &copy; 
            <script>
                document.write(new Date().getFullYear());
            </script> 
            <strong><span><a href="https://twitter.com/KrishnaAditya16" style="color:inherit">Krishna Aditya</a></span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexstart-bootstrap-startup-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

@endsection