<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    // Apply the auth logic only when Filament is serving requests
    Filament::serving(function () {
      Filament::auth(function () {
        $user = auth()->user();

        // Ensure the user is logged in and has the admin role
        return $user && $user->role === 'admin';
      });
    });
  }
}
