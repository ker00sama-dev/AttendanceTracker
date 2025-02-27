@php
  use Illuminate\Support\Facades\Route;
  $configData = Helper::appClasses();
  $customizerHidden = 'customizer-hide';
  $departments = \App\Models\Departments::all();
  $collegeYears = \App\Models\CollegeYear::all();
@endphp

@extends('layouts/blankLayout')

@section('title', __('Student Registration'))

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

        <!-- Student Registration Card -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-6">
              <a href="{{url('/')}}" class="app-brand-link">
                <span
                  class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
                <span class="app-brand-text demo text-heading fw-bold">{{ __(config('variables.templateName')) }}</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1">{{ __('Join us today for a brighter future! 🎓') }}</h4>
            <p class="mb-6">{{ __('Create your student account and access a world of opportunities.') }}</p>

            <form id="formAuthentication" class="mb-6" action="{{ route('register') }}" method="POST">
              @csrf
              <div class="mb-6">
                <label for="username" class="form-label">{{ __('Full Name') }}</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="username" name="name" placeholder="{{ __('Enter your full name') }}"
                       autofocus value="{{ old('name') }}" />
                @error('name')
                <span class="invalid-feedback" role="alert">
                  <span class="fw-medium">{{ $message }}</span>
                </span>
                @enderror
              </div>
              <div class="mb-6">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                       name="email" placeholder="{{ __('Enter your email address') }}"
                       value="{{ old('email') }}" />
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <span class="fw-medium">{{ $message }}</span>
                </span>
                @enderror
              </div>

              <div class="mb-6">
                <label for="college_card_id" class="form-label">{{ __('College Card ID') }}</label>
                <input
                  type="number"
                  class="form-control @error('college_card_id') is-invalid @enderror"
                  id="college_card_id"
                  name="college_card_id"
                  placeholder="{{ __('Enter your College Card ID') }}"
                  value="{{ old('college_card_id') }}"
                  required
                />
                @error('college_card_id')
                <span class="invalid-feedback" role="alert">
    <span class="fw-medium">{{ $message }}</span>
  </span>
                @enderror
              </div>


              <div class="mb-6">
                <label for="college_year_id" class="form-label">{{ __('College Year') }}</label>
                <select class="form-select @error('college_year_id') is-invalid @enderror" id="college_year_id" name="college_year_id" required>
                  <option value="">{{ __('Select your college year') }}</option>
                  @foreach ($collegeYears as $year)
                    <option value="{{ $year->id }}" {{ old('college_year_id') == $year->id ? 'selected' : '' }}>
                      {{ __($year->year_name) }}
                    </option>
                  @endforeach
                </select>
                @error('college_year_id')
                <span class="invalid-feedback" role="alert">
            <span class="fw-medium">{{ $message }}</span>
        </span>
                @enderror
              </div>

              <div class="mb-6">
                <label for="department_id" class="form-label">{{ __('Department') }}</label>
                <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id" required>
                  <option value="">{{ __('Select your department') }}</option>
                  @foreach ($departments as $department)
                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                      {{ __($department->name) }}
                    </option>
                  @endforeach
                </select>
                @error('department_id')
                <span class="invalid-feedback" role="alert">
            <span class="fw-medium">{{ $message }}</span>
        </span>
                @enderror
              </div>

              <div class="mb-6">
                <label for="phone_number"
                       class="form-label">{{ __('Phone Number (e.g., 01000000000)') }}</label>
                <input
                  type="tel"
                  maxlength="11"
                  minlength="11"
                  pattern="^01[0-2,5]{1}[0-9]{8}$"
                  class="form-control @error('phone_number') is-invalid @enderror"
                  id="phone_number"
                  name="phone_number"
                  placeholder="01000000000"
                  value="{{ old('phone_number') }}"
                  required
                />
                @error('phone_number')
                <span class="invalid-feedback" role="alert">
    <span class="fw-medium">{{ $message }}</span>
  </span>
                @enderror
              </div>


              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">{{ __('Password') }}</label>
                <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                  <input type="password" id="password"
                         class="form-control @error('password') is-invalid @enderror" name="password"
                         placeholder="{{ __('Enter a strong password') }}"
                         aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <span class="fw-medium">{{ $message }}</span>
                </span>
                @enderror
              </div>

              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password-confirm" class="form-control"
                         name="password_confirmation" placeholder="{{ __('Re-enter your password') }}"
                         aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
              </div>
              @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mb-6 mt-8">
                  <div class="form-check mb-8 ms-2 @error('terms') is-invalid @enderror">
                    <input class="form-check-input @error('terms') is-invalid @enderror"
                           type="checkbox" id="terms" name="terms" />
                    <label class="form-check-label" for="terms">
                      {{ __('I agree to the') }}
                      <a href="{{ route('policy.show') }}"
                         target="_blank">{{ __('privacy policy') }}</a> &
                      <a href="{{ route('terms.show') }}" target="_blank">{{ __('terms') }}</a>
                    </label>
                  </div>
                  @error('terms')
                  <div class="invalid-feedback" role="alert">
                    <span class="fw-medium">{{ $message }}</span>
                  </div>
                  @enderror
                </div>
              @endif
              <button type="submit" class="btn btn-primary d-grid w-100">{{ __('Sign Up') }}</button>
            </form>

            <p class="text-center">
              <span>{{ __('Already have an account?') }}</span>
              @if (Route::has('login'))
                <a href="{{ route('login') }}">
                  <span>{{ __('Sign in here') }}</span>
                </a>
              @endif
            </p>


          </div>
        </div>
        <!-- Student Registration Card -->
      </div>
    </div>
  </div>
@endsection
