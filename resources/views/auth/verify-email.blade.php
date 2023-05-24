@extends('auth.base')

@section('title', 'Verify Email')

@section('content')
<div id="app">
    <section class="section">
        <div class="d-flex flex-wrap align-items-stretch">
            <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                <div class="p-4 m-3">
                    <div class="logo-mobile">
                        <img src="{{ asset('auth/img/logo_circle.png') }}" alt="logo" width="80" class="shadow-light rounded-circle mb-5 mt-2">
                    </div>
                    <h4 class="text-dark font-weight-normal">Welcome to <span class="font-weight-bold">PM App</span></h4>
                    <p class="text-muted">Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                    
                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                            </div>
                        @endif
                
                        <div class="mt-4 flex items-center justify-between">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Resend Verification Email') }}
                                    </button>
                                </div>
                            </form>

                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-12 col-md-3 mt-2">
                                        <a href="{{ route('profile.show') }}" class="btn btn-outline-primary">{{ __('Edit Profile') }}</a>
                                    </div>
                                    <div class="col-12 col-md-9 mt-2">
                                        <form method="POST" action="{{ route('logout') }}" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary">
                                                {{ __('Log Out') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    
                    <div class="pt-5 pb-2 mt-5"></div>

                    <div class="mt-5 pt-5 text-center"> <hr> </div>

                    <div class="mt-5 text-center">
                        Copyright &copy; <script>
                            document.write(new Date().getFullYear());
                        </script>
                        <div class="bullet"></div> Made by <a href="https://twitter.com/KrishnaAditya16"> Krishna Aditya </a>&nbsp;
                    </div>

                </div>
            </div>
            <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom hidden-mobile-auth" data-background="{{ asset('auth/img/unsplash/login-bg.jpg') }}">
                <div class="absolute-bottom-left index-2">
                    <div class="text-light p-5 pb-2">
                        <div class="mb-5 pb-3">
                            <h1 class="mb-2 display-4 font-weight-bold">Good Morning</h1>
                            <h5 class="font-weight-normal text-muted-transparent">Bali, Indonesia</h5>
                        </div>
                        Photo by <a class="text-light bb" target="_blank" href="https://unsplash.com/photos/a8lTjWJJgLA">Justin Kauffman</a> on <a class="text-light bb" target="_blank" href="https://unsplash.com">Unsplash</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection


