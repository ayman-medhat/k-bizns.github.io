<?php

namespace App\Traits;

use App\Models\Company;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (! $model->company_id) {
                if (session()->has('company_id')) {
                    $model->company_id = session('company_id');
                } elseif (auth()->check()) {
                    $model->company_id = auth()->user()->company_id;
                }
            }
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
