<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use BelongsToTenant, HasFactory, HasOwner;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'address', // Keep standard address field for now if needed, but we use address_id too
        'logo_path',
        'industry_id',
        'address_id',
        'phone_country_id',
        'status',
        'company_id',
        'user_id',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function phoneCountry()
    {
        return $this->belongsTo(Country::class, 'phone_country_id');
    }

    public function addressRel()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
