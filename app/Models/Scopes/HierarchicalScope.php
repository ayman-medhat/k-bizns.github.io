<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HierarchicalScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Super Admin and Company Admin can see everything in their company (handled by TenantScope)
            if ($user->hasRole(['Super Admin', 'Company Admin']) || $user->isRoot()) {
                return;
            }

            // Other users see their own data + subordinates' data
            $subordinateIds = $user->getAllSubordinateIds();
            $allowedUserIds = array_merge([$user->id], $subordinateIds);

            // Assumes the model has a user_id column
            if (\Schema::hasColumn($model->getTable(), 'user_id')) {
                $builder->whereIn($model->getTable().'.user_id', $allowedUserIds);
            }
        }
    }
}
