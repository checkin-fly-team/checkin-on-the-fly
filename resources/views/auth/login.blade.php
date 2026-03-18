@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center  align-items-center justify-content-center">
    <div class="login-card p-5 shadow-sm">
        <div class="text-center mb-4">
            <h1 class="fw-bolder mb-0" style="font-size: 4.5rem; letter-spacing: -2px;">{{ __('Login') }}</h1>
            <h3 class="fw-normal">{{ __('Dashboard') }}</h3>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" 
                       class="form-control form-control-lg border-0 rounded-3 py-2 @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" 
                       placeholder="john@checkin.onthefly.com"
                       required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" 
                       class="form-control form-control-lg border-0 rounded-3 py-2 @error('password') is-invalid @enderror" 
                       name="password" 
                       placeholder="********"
                       required autocomplete="current-password" autofocus>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <input type="hidden" name="remember" value="on"> 


            <div class="d-flex justify-content-between align-items-center mt-2">
                
                @if (Route::has('password.request'))
                    <a class="text-primary text-decoration-none" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif

                <button type="submit" class="btn btn-dark btn-lg rounded-3 px-4">
                    {{ __('Login') }}
                </button>
                
            </div>
        </form>
    </div>
</div>
@endsection