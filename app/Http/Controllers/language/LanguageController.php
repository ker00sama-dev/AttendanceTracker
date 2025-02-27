<?php

namespace App\Http\Controllers\language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Helpers\Helpers;

class LanguageController extends Controller
{

  public function swap(Request $request, $locale)
  {
    if (!in_array($locale, ['en', 'ar'])) {
      $locale = 'ar';
    } else {
      $request->session()->put('locale', $locale);
    }
    // Set RTL or LTR
    $locale == 'ar' ? Helpers::setRTL() : Helpers::setLTR();




    App::setLocale($locale);

    return redirect()->back();
  }


}
