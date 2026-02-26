<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $company = $user->company;

            if ($company) {
                session(['company_id' => $company->id]);

                // Trial ends check
                if ($company->trial_ends_at && $company->trial_ends_at->isPast()) {
                    // Check if they have an active subscription
                    $activeSubscription = \App\Models\CompanySubscription::where('company_id', $company->id)
                        ->where('status', 'active')
                        ->where('ends_at', '>', now())
                        ->exists();

                    if (! $activeSubscription) {
                        // Redirect to subscription page if not on one or if it's not a root user
                        if (! $user->is_root && ! $request->is('subscription*') && ! $request->is('logout')) {
                            // For now redirect to a placeholder or return error
                            return response()->view('errors.subscription_expired', [], 403);
                        }
                    }
                }
            }
        }

        return $next($request);
    }
}
