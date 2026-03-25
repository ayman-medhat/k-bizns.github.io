<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use BelongsToTenant, HasFactory, HasOwner;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company_name',
        'status',
        'source',
        'value',
        'company_id',
        'user_id',
    ];

    public function getNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
