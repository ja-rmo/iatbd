<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;


class CheckIfBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if($user) {
            if ($user->role !== 'admin' && $user->blocked) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['blocked' => 'You are blocked']);
            }
        }
        return $next($request);
    }
}
