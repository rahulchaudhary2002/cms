@extends('layouts.plain')

@section('content')
<div class="page auth">
    <div class="auth__container">
        <div class="auth__banner"></div>
        <div class="auth__form-section">
            <img src="{{ asset('assets/images/cms.png') }}" alt="CMS" class="logo">
            <div class="form-content">
                <h6>Reset Password</h6>
                
                <form method="POST" action="{{ route('password.update') }}" class="auth-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter email address" value="{{ $email ?? old('email') }}">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

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
