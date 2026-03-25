<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLocaleFromPreference
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && $pref = Auth::user()->preference) {
            $locale = $pref->locale ?? config('app.locale');
            App::setLocale($locale);
        }

        return $next($request);
    }
}
