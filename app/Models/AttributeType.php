<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeType extends Model
{
    protected $fillable = ['name', 'slug', 'display_type'];

    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class)->orderBy('sort_order');
    }
}
