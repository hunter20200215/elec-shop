<?php

namespace App\Models;

use App\Traits\HasModelImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use HasModelImage;

    protected $with = ['model_images'];

    protected $fillable = [
        'name', 'price', 'category_id', 'description', 'trending', 'slug', 'published', 'sku', 'quantity'
    ];
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function product_attribute_values(){
        return $this->hasMany(Product_attribute_value::class);
    }

    public function getProductAttributeValueIDs(){
        return $this->product_attribute_values->pluck('attribute_value_id')->toArray();
    }
    public function getPrice(){
        return number_format($this->price / 100, 2);
    }
    public function getGBV(){
        return number_format(($this->price * $this->quantity) / 100, 2);
    }

    // Local scopes
    public function scopePublished($query){
        return $query->where('published', 1);
    }
    public function scopeInCategories($query, $categories){
        return sizeof($categories) > 0 ? $query->whereIn('category_id', $categories) : $query;
    }
    public function scopeHasAttributeValue($query, $key, $ids){
        if(sizeof($ids) > 0){
            return $query->join("product_attribute_values as p$key", "p$key.product_id", 'products.id')->whereIn("p$key.attribute_value_id", $ids);
        }
        else return $query;
    }
    public function scopeMaxPrice($query, $price){
        return $price ? $query->where('price', '<', $price*100) : $query;
    }
    public function scopeMinPrice($query, $price){
        return $price ? $query->where('price', '>', $price*100) : $query;
    }
    public function scopeIsCalled($query, $term){
        return $term ? $query->where('name', 'iLike', "%$term%") : $query;
    }
    public function scopeTrending($query, $trending){
        return $trending ? $query->where('trending', 1) : $query;
    }
}
