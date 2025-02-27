<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
  /**
   * Handle an incoming request.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Check if the authenticated user exists and is an admin
    if (!auth()->check() || auth()->user()->role !== 'admin') {
      // Optionally redirect or return a 403 Forbidden response
      abort(403, 'Unauthorized action.');
    }

    // Allow the request to proceed
    return $next($request);
  }

}
