<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactPaper extends Model
{
    protected $guarded = [];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
