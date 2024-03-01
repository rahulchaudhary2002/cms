@extends('layouts.plain')

@section('title', 'Change Password')

@section('content')
<div class="page auth">
    <div class="auth__container">
        <div class="auth__banner"></div>
        <div class="auth__form-section">
            <img src="{{ asset('assets/images/cms.png') }}" alt="CMS" class="logo">
            <div class="form-content">
                <h6>Change Password</h6>
                <p>Enter new password</p>

                <form method="POST" action="{{ route('password.changing') }}" class="auth-form">
                    @csrf
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter password">
                        @error('password')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Enter password">
                        @error('password_confirmation')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (Route::has('password.request'))
                    <div class="right-aligned">
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    </div>
                    @endif

                    <button class="primary" type="submit">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection