<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AddUserToView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user) {
            // Hide sensitive attributes
            $user->makeHidden(['password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at', 'email', 'id']);
            View::share('user', $user);
        }

        return $next($request);
    }
}
