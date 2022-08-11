@extends('layouts.app')

@section('content')
    <form class="login100-form validate-form" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="login100-form-avatar">
            <img src="{{ asset('auth-login/images/logo.png') }}" alt="AVATAR">
        </div>
        <span class="login100-form-title p-t-20 p-b-45">
            O'zbekiston Temir Yo'llari
        </span>
        <div class="wrap-input100 validate-input m-b-10" data-validate="Username is required">
            <input class="input100 @error('email') is-invalid @enderror" value="{{ old('email') }}" type="email"
                name="email" placeholder="Email" required autocomplete="email" autofocus>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-at"></i>
            </span>
        </div>
        <div class="wrap-input100 validate-input m-b-10" data-validate="Password is required">
            <input class="input100  @error('password') is-invalid @enderror" type="password" name="password"
                placeholder="Password" required autocomplete="current-password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-lock"></i>
            </span>
        </div>
        @error('email')
            <h6 class="text-center txt1 fw-bold w-full">{{ $message }}</h6>
        @enderror
        <div class="container-login100-form-btn p-t-10">
            <button class="login100-form-btn" type="submit">
                Login
            </button>
        </div>
        <div class="text-center w-full p-t-25 p-b-230">
            <a href="#" class="txt1">
            </a>
        </div>
        <div class="text-center w-full">
            <a class="txt1" href="javascript:void(0)" id="myDiv"></a>
        </div>
    </form>
@endsection
