<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Colors\Color;

class ApplyTheme
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && $pref = Auth::user()->preference) {
            $theme = $pref->theme ?? 'royal-brown';

            // Set Filament Colors dynamically
            if ($theme === 'emerald') {
                FilamentColor::register(['primary' => Color::Emerald]);
            } elseif ($theme === 'sapphire') {
                FilamentColor::register(['primary' => Color::Blue]);
            } else {
                // Default Royal Brown
                FilamentColor::register(['primary' => Color::hex('#D2B48C')]);
            }
        }

        return $next($request);
    }
}
