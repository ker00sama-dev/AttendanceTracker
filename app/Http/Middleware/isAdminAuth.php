<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdminAuth
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function handle(Request $request, Closure $next): Response
  {
    // List of authorized roles
    $authorizedRoles = ['admin', 'professor', 'instructor'];

    // Check if the authenticated user exists and has an authorized role
    if (!auth()->check() || !in_array(auth()->user()->role, $authorizedRoles)) {
      // Deny access with a 403 Forbidden response
      abort(403, 'Unauthorized action.');
    }

    // Allow the request to proceed
    return $next($request);
  }
}
