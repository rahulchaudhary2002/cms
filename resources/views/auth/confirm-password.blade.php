@extends('layouts.plain')

@section('content')
<div class="page auth">
    <div class="auth__container">
        <div class="auth__banner"></div>
        <div class="auth__form-section">
            <img src="{{ asset('assets/images/cms.png') }}" alt="CMS" class="logo">
            <div class="form-content">
                <h6>Confirm Password</h6>
                <p>Please confirm your password before continuing</p>
                <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
                    @csrf
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
                        Confirm Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection