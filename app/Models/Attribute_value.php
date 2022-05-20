<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Attribute_value extends Model
{
    protected $fillable = [
        'value', 'attribute_id', 'color'
    ];

    protected static function booted()
    {
        static::addGlobalScope('orderByValue', function (Builder $builder) {
            $builder->orderBy('value');
        });
    }

    public function attribute() {
        return $this->belongsTo(Attribute::class);
    }
}
