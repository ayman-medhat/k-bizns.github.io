<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Employee extends Model
{
    use BelongsToTenant, HasFactory, HasTranslations, SoftDeletes;

    public array $translatable = ['name_translations'];

    protected $fillable = [
        'company_id',
        'name_translations',
        'employee_number',
        'job_title',
        'department',
        'email',
        'phone',
        'hire_date',
        'birth_date',
        'status',
        'gender',
        'national_id',
        'basic_salary',
        'currency',
        'bank_account',
        'photo',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'name_translations' => 'array',
            'hire_date' => 'date',
            'birth_date' => 'date',
            'basic_salary' => 'decimal:2',
        ];
    }

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->name_translations[$locale]
            ?? $this->name_translations['en']
            ?? '';
    }

    public function payrollItems()
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
