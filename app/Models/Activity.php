<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    use BelongsToTenant, HasFactory, HasOwner;

    protected $fillable = ['description', 'type', 'subject_id', 'subject_type', 'user_id', 'company_id'];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
