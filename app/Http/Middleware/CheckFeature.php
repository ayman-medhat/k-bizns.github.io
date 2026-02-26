<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFeature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        $featureGate = app(\App\Services\FeatureGate::class);

        if (! $featureGate->hasFeature($feature)) {
            return response()->view('errors.feature_locked', ['feature' => $feature], 403);
        }

        return $next($request);
    }
}
