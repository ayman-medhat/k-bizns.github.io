<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalEntry extends Model
{
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'company_id',
        'number',
        'journal_id',
        'entry_date',
        'reference',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return ['entry_date' => 'date'];
    }

    public static function generateNumber(): string
    {
        $last = static::max('id') ?? 0;
        return 'JE-' . str_pad($last + 1, 5, '0', STR_PAD_LEFT);
    }

    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(JournalEntryLine::class);
    }
}
