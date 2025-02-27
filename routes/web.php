<?php


use App\Http\Controllers\AttendanceQRController;
use App\Http\Controllers\language\LanguageController;
use App\Livewire\Attendrate;
use App\Livewire\User\Home;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);


Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified',
])->group(function () {
  Route::get('/', Home::class)->name('home');
  Route::get('/dashboard', function () {
       return  redirect()->route('home');
  })->name('dashboard');


  Route::get('/attendance', function () {
    return view('pages.pages-misc-comingsoon');
  })->name('Attendrate');


  Route::get('/lectures', function () {
    return view('pages.pages-misc-comingsoon');
  })->name('lectures');

  Route::get('/subjects', function () {
    return view('pages.pages-misc-comingsoon');
  })->name('subjects');


  //Route Scan QR Code
  Route::get('/scan/{data}', [AttendanceQRController::class, 'scan'])->name('scan');
  Route::get('/clear-all-cache', function () {
    // Assuming you have "notyf" configured and available in your views
    sweetalert()->success(__('Cache cleared successfully!'));

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
    Artisan::call('optimize');


    return redirect()->back();
  })->name('clear-all-cache')->middleware(\App\Http\Middleware\isAdmin::class);

  Route::get('/user/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
  })->name('user.logout');



});
