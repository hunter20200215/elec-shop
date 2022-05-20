<?php

namespace App\Models;

use App\Traits\HasModelImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use HasModelImage;

    protected $fillable = ['name', 'status', 'priority', 'slug', 'featured'];

    protected $with = ['model_images'];

    protected static function booted()
    {
        static::addGlobalScope('orderByName', function (Builder $builder) {
            $builder->orderBy('name');
        });
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
    public function scopeFeatured($query){
        return $query->where('featured', 1);
    }
}
