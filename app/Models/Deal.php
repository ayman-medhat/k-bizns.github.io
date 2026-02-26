<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deal extends Model
{
    use BelongsToTenant, HasFactory, HasOwner;

    protected $fillable = ['title', 'value', 'status', 'client_id', 'company_id', 'user_id'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
