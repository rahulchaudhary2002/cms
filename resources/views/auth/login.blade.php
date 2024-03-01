@extends('layouts.plain')

@section('content')
<div class="page auth">
    <div class="auth__container">
        <div class="auth__banner"></div>
        <div class="auth__form-section">
            <img src="{{ asset('assets/images/cms.png') }}" alt="CMS" class="logo">
            <div class="form-content">
                <h6>Login</h6>
                <p>Enter your email and password</p>
                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter email address" value="{{ old('email') }}" >
                        @error('email')
                        <span class="error">{{ $message }}</span>
                        @enderror
                        @if(session('error'))
                        <span class="error">{{ session('error') }}</span>
                        @endif
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter password">
                        @error('password')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (Route::has('password.request'))
                    <div class="right-aligned">
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    </div>
                    @endif

                    <button class="primary" type="submit">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection