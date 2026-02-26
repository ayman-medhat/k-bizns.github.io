<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $limit): Response
    {
        if ($request->isMethod('POST')) {
            $featureGate = app(\App\Services\FeatureGate::class);

            $counts = [
                'max_users' => \App\Models\User::count(),
                'max_clients' => \App\Models\Client::count(),
                'max_contacts' => \App\Models\Contact::count(),
                'max_deals' => \App\Models\Deal::count(),
            ];

            $currentCount = $counts[$limit] ?? 0;

            if (! $featureGate->checkLimit($limit, $currentCount)) {
                return back()->withErrors(['limit' => "Your plan limit for $limit has been reached."]);
            }
        }

        return $next($request);
    }
}
