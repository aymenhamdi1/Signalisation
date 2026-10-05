<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LastActive
{
    /**
     * Gère une requête entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $user = Auth::user();

        if ($user && $user->status === 'active') {
            $expireTime = Carbon::now()->addSeconds(30);
            $cacheKey = 'online:' . $user->id;

            Cache::put($cacheKey, true, $expireTime);

            $lastActive = Carbon::parse($user->last_active_at);

            if (!$lastActive || $lastActive->diffInSeconds(Carbon::now()) > 30) {
                $user->update(['last_active_at' => Carbon::now()]);
            }
        }

        return $response;
    }
}
