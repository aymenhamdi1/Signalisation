<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockAccess
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
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->status !== 'active') {
                Auth::logout();

                $notification = [
                    'message' => 'Hi (' . $user->name . ' ' . $user->username . '), your account has been created. An email will be sent to you after account verification. THANKS',
                    'alert-type' => 'question'
                ];

                return redirect('/login')->with($notification);
            }
        }

        return $next($request);
    }
}
