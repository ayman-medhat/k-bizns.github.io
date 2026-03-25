<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use BelongsToTenant, HasFactory, HasOwner;

    protected $fillable = [
        'first_name_en',
        'first_name_ar',
        'last_name_en',
        'last_name_ar',
        'email',
        'phone',
        'phone_country_id',
        'client_id',
        'nationality_id',
        'national_id',
        'passport_no',
        'birthdate',
        'category',
        'address_id',
        'photo_path',
        'company_id',
        'user_id',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($contact) {
            // Auto-calculate birthdate from Egyptian National ID
            if ($contact->national_id) {
                // Check if nationality is Egyptian
                $isEgyptian = false;
                if ($contact->nationality_id) {
                    $country = \App\Models\Country::find($contact->nationality_id);
                    if ($country && (stripos($country->name_en, 'egypt') !== false || stripos($country->nationality_en, 'egypt') !== false)) {
                        $isEgyptian = true;
                    }
                }

                if ($isEgyptian) {
                    $id = $contact->national_id;

                    if (strlen($id) === 14) {
                        $century = substr($id, 0, 1);
                        $year = substr($id, 1, 2);
                        $month = substr($id, 3, 2);
                        $day = substr($id, 5, 2);

                        $fullYear = ($century == 2 ? '19' : '20') . $year;

                        try {
                            $contact->birthdate = \Carbon\Carbon::createFromDate($fullYear, $month, $day);
                        } catch (\Exception $e) {
                            // Invalid date, ignore
                        }
                    }
                }
            }
        });
    }

    // Accessors
    public function getAgeAttribute()
    {
        if (!$this->birthdate) {
            return null;
        }

        $birthdate = \Carbon\Carbon::parse($this->birthdate);
        $diff = $birthdate->diff(\Carbon\Carbon::now());

        $parts = [];
        if ($diff->y > 0) {
            $parts[] = $diff->y . ' years';
        }
        if ($diff->m > 0) {
            $parts[] = $diff->m . ' months';
        }
        if ($diff->d > 0) {
            $parts[] = $diff->d . ' days';
        }

        return implode(', ', $parts) ?: '0 days';
    }

    public function getNameAttribute()
    {
        return "{$this->first_name_en} {$this->last_name_en}";
    }

    public function getFirstNameAttribute()
    {
        return $this->first_name_en;
    }

    public function getLastNameAttribute()
    {
        return $this->last_name_en;
    }

    public function getFullPhoneAttribute()
    {
        if (!$this->phone) {
            return '-';
        }
        $code = $this->phoneCountry ? "+{$this->phoneCountry->phone_code} " : '';

        return $code . $this->phone;
    }

    // Relationships
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function phoneCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'phone_country_id');
    }

    public function papers(): HasMany
    {
        return $this->hasMany(ContactPaper::class);
    }
}
