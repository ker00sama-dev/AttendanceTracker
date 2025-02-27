@php
  use Illuminate\Support\Facades\Route;
  $configData = Helper::appClasses();
  $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', __('Login'))

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/@form-validation/form-validation.scss'
  ])
@endsection

@section('page-style')
  @vite([
    'resources/assets/vendor/scss/pages/page-auth.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js'
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/pages-auth.js'
  ])
@endsection

@section('content')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-6">
        <!-- Login -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-6">
              <a href="{{url('/')}}" class="app-brand-link">
                <span class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
                <span class="app-brand-text demo text-heading fw-bold">{{ __(config('variables.templateName')) }}</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1">{{ __('Welcome to :templateName! 👋', ['templateName' => __(config('variables.templateName'))]) }}</h4>
            <p class="mb-6">{{ __('Please sign-in to your account') }}</p>

            @if (session('status'))
              <div class="alert alert-success mb-1 rounded-0" role="alert">
                <div class="alert-body">
                  {{ session('status') }}
                </div>
              </div>
            @endif

            <form id="formAuthentication" class="mb-6" action="{{ route('login') }}" method="POST">
              @csrf
              <div class="mb-6">
                <label for="login-email" class="form-label">{{ __('Email') }}</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="login-email" name="email" placeholder="{{ __('Enter your email') }}" autofocus value="{{ old('email') }}">
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <span class="fw-medium">{{ $message }}</span>
                </span>
                @enderror
              </div>
              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="login-password">{{ __('Password') }}</label>
                <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                  <input type="password" id="login-password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <span class="fw-medium">{{ $message }}</span>
                </span>
                @enderror
              </div>
              <div class="my-8">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0 ms-2">
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember-me">
                      {{ __('Remember Me') }}
                    </label>
                  </div>
                  @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                      <p class="mb-0">{{ __('Forgot Password?') }}</p>
                    </a>
                  @endif
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Sign in') }}</button>
            </form>

            <p class="text-center">
              <span>{{ __('New on our platform?') }}</span>
              @if (Route::has('register'))
                <a href="{{ route('register') }}">
                  <span>{{ __('Create an account') }}</span>
                </a>
              @endif
            </p>

          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>
@endsection
