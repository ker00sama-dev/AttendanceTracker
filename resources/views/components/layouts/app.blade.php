
@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

@php
  $configData = Helper::appClasses();
  /* Display elements */
  $contentNavbar = $contentNavbar ?? true;
  $containerNav = $containerNav ?? 'container-xxl';
  $isNavbar = $isNavbar ?? true;
  $isMenu = $isMenu ?? true;
  $isFlex = $isFlex ?? false;
  $isFooter = $isFooter ?? true;
  $customizerHidden = $customizerHidden ?? '';

  /* HTML Classes */
  $navbarDetached = 'navbar-detached';
  $menuFixed = $configData['menuFixed'] ?? '';
  $navbarType = $navbarType ?? ($configData['navbarType'] ?? '');
  $footerFixed = $configData['footerFixed'] ?? '';
  $menuCollapsed = $configData['menuCollapsed'] ?? '';

  /* Content classes */
  $container = ($configData['contentLayout'] ?? '') === 'compact' ? 'container-xxl' : 'container-fluid';

  /* Layout adjustments */
  $menuFixed = $configData['layout'] === 'vertical' ? ($menuFixed ?? '') : ($configData['layout'] === 'front' ? '' : $configData['headerType'] ?? '');
  $navbarType = $configData['layout'] === 'vertical' ? ($navbarType ?? '') : ($configData['layout'] === 'front' ? 'layout-navbar-fixed' : '');
  $isFront = ($isFront ?? false) ? 'Front' : '';
  $contentLayout = ($container === 'container-xxl') ? "layout-compact" : "layout-wide";
  $isRtl = \App\Helpers\Helpers::isRTL() ? 'rtl' : 'ltr';

  $title = $title ?? 'Page Title';
@endphp
  <!DOCTYPE html>
<html lang="{{ session()->get('locale') ?? app()->getLocale() }}"
      class="{{ $configData['style'] }}-style {{ $contentLayout }} {{ $navbarType }} {{ $menuFixed }} {{ $menuCollapsed }} {{ $footerFixed }} {{ $customizerHidden }}"
      dir="{{ $isRtl }}" data-theme="{{ $configData['theme'] }}"
      data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{ url('/') }}" data-framework="laravel"
      data-template="{{ $configData['layout'] . '-menu-' . $configData['themeOpt'] . '-' . $configData['styleOpt'] }}"
      data-style="{{ $configData['styleOptVal'] }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>{{ __($title) ?? 'Page Title' }} | {{ __(config('variables.templateName', 'TemplateName')) }}
    - {{ __(config('variables.templateSuffix', 'TemplateSuffix')) }}</title>
  <meta name="description" content="{{ config('variables.templateDescription', '') }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword', '') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="canonical" href="{{ config('variables.productPage', '') }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

  <!-- Include Styles -->
  @include('layouts/sections/styles' . $isFront)

  <!-- Include Scripts -->
  @include('layouts/sections/scriptsIncludes' . $isFront)
</head>

<body>



<!-- Tostar -->

<div class="layout-wrapper layout-content-navbar {{ $isMenu ? '' : 'layout-without-menu' }}">
  <div class="layout-container">

    @if ($isMenu)
      @include('layouts.sections.menu.verticalMenu')
    @endif


    <!-- Layout page -->
    <div class="layout-page">

      {{-- Below commented code read by artisan command while installing jetstream. !! Do not remove if you want to use jetstream. --}}
      <x-banner />

      <!-- BEGIN: Navbar-->
      @if ($isNavbar)
        @include('layouts/sections/navbar/navbar')
      @endif
      <!-- END: Navbar-->


      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        @if ($isFlex)
          <div class="{{$container}} d-flex align-items-stretch flex-grow-1 p-0">
            @else
              <div class="{{$container}} flex-grow-1 container-p-y">
                @endif

                {{ $slot ?? ''}}

              </div>
              <!-- / Content -->

              <!-- Footer -->
              @if ($isFooter)
                @include('layouts/sections/footer/footer')
              @endif
              <!-- / Footer -->
              <div class="content-backdrop fade"></div>
          </div>
          <!--/ Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    @if ($isMenu)
      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    @endif
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
  <!-- / Layout wrapper -->


  <!-- Include Scripts -->
  <!-- $isFront is used to append the front layout scripts only on the front layout otherwise the variable will be blank -->
  @include('layouts/sections/scripts' . $isFront)
</div>

</body>
</html>
