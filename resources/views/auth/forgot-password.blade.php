@extends('layouts.plain')

@section('content')
<div class="page auth">
    <div class="auth__container">
        <div class="auth__banner"></div>
        <div class="auth__form-section">
            <img src="{{ asset('assets/images/cms.png') }}" alt="CMS" class="logo">
            <div class="form-content">
                @if (Session::has('status'))
                <div class="alert alert-success" role="alert">
                    Password reset link has been send to your email!
                </div>
                @endif
                <h6>Reset Password</h6>
                <p>Enter your email and we will send you a password reset link on your inbox</p>
                <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                    @csrf
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter email address" value="{{ old('email') }}">
                        @error('email')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="right-aligned">
                        <a href="{{ route('login') }}">Go back to login</a>
                    </div>

                    <button class="primary" type="submit">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection