<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name_en', 'name_ar', 'nationality_en', 'nationality_ar', 'phone_code'];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
