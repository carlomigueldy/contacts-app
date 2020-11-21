<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    /**
     * A contact will have many custom attributes.
     *
     * @return HasMany
     */
    public function customAttributes(): HasMany
    {
        return $this->hasMany(CustomAttribute::class);
    }
}
