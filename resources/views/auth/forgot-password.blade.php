@extends('auth.base')

@section('title', 'Forgot Password')

@section('content')
<div id="app">
    <section class="section">
        <div class="d-flex flex-wrap align-items-stretch">
            <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                <div class="p-4 m-3">
                    <div class="logo-mobile">
                        <img src="{{ asset('auth/img/logo_circle.png') }}" alt="logo" width="80" class="shadow-light rounded-circle mb-5 mt-2">
                    </div>
                    <h4 class="text-dark font-weight-normal">Welcome to <span class="font-weight-bold">{{ config('app.name', 'Laravel') }}</span></h4>
                    <p class="text-muted">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mt-5"></div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Email Password Reset Link') }}
                            </button>
                        </div>

                        <div class="mt-5 text-center">
                            Back to login page? <a href="{{ route('login') }}">Login</a> 
                        </div>
                    </form>

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