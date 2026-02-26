<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'features',
        'limits',
        'price',
        'interval',
    ];

    protected $casts = [
        'features' => 'array',
        'limits' => 'array',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(CompanySubscription::class);
    }
}
