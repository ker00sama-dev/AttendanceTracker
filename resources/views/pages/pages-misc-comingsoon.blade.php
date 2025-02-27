@php
  $customizerHidden = 'customizer-hide';
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')


@section('title', __('Coming Soon'))

@section('page-style')
  @vite('resources/assets/vendor/scss/pages/page-misc.scss')
@endsection
@section('content')
  <!-- Coming Soon -->
  <div class="container-xxl container-p-y py-4">
    <div class="misc-wrapper">
      <h4 class="mb-2 mx-2">{{ __('We are launching soon 🚀') }}</h4>
      <p class="mb-6 mx-2">{{ __('Our feature/website is opening soon.') }}</p>



      <div class="mt-12">
        <img src="{{ asset('assets/img/illustrations/page-misc-launching-soon.png') }}" alt="{{ __('page-misc-launching-soon') }}" width="263" class="img-fluid">
      </div>
    </div>
  </div>

  <div class="container-fluid misc-bg-wrapper">
    <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}" height="355" alt="{{ __('page-misc-coming-soon') }}" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png">
  </div>
  <!-- /Coming soon -->
@endsection
