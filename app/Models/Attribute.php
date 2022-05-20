<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'name', 'show_on_search', 'search_type'
    ];

    protected $with = ['attribute_values'];

    public function attribute_values(){
        return $this->hasMany(Attribute_value::class);
    }
    public function getFirstValueType(){
        return $this->attribute_values->first()?->color;
    }
    public function scopeVisibleOnSearch($query){
        return $query->where('show_on_search', 1);
    }
}
