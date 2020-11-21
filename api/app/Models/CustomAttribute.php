<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomAttribute extends Model
{
    use HasFactory;

    /**
     * A set of custom attributes belongs to a Contact.
     *
     * @return BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
