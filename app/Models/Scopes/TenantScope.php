<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    protected static $resolving = false;

    public function apply(Builder $builder, Model $model): void
    {
        if (static::$resolving) {
            return;
        }

        static::$resolving = true;

        try {
            // Super Admin / root users must be able to view across companies (e.g. super-admin pages).
            if (auth()->hasUser()) {
                $user = auth()->user();
                $isSuperAdmin = method_exists($user, 'hasRole') && $user->hasRole('Super Admin');
                $isRoot = method_exists($user, 'isRoot') ? $user->isRoot() : (bool) ($user->is_root ?? false);

                if ($isSuperAdmin || $isRoot) {
                    return;
                }
            }

            if (session()->has('company_id')) {
                $builder->where($model->getTable().'.company_id', session('company_id'));
            } elseif (auth()->hasUser()) {
                $user = auth()->user();
                if ($user->company_id && ! ($model instanceof \App\Models\User)) {
                    $builder->where($model->getTable().'.company_id', $user->company_id);
                }
            }
        } finally {
            static::$resolving = false;
        }
    }
}
