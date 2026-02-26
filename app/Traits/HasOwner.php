<?php

namespace App\Traits;

use App\Models\Scopes\HierarchicalScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasOwner
{
    protected static function bootHasOwner()
    {
        static::addGlobalScope(new HierarchicalScope);

        static::creating(function ($model) {
            if (! $model->user_id && auth()->check()) {
                $model->user_id = auth()->id();
            }
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
