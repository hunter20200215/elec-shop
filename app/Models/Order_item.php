<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'price', 'product_id', 'quantity', 'status'];

    protected $with = ['product'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function getPrice(){
        return number_format($this->price / 100, 2);
    }
}
