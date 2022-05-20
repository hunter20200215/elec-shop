<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['status', 'user_id', 'order_date', 'price', 'note', 'shipping'];

    protected $with = ['order_items'];

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function order_items(){
        return $this->hasMany(Order_item::class)->orderBy('id');
    }
    public function getUser(){
        if ($this->user_id) return $this->user->full_name;
        else return $this->email;
    }

    public function getPrice(){
        return number_format($this->price / 100, 2);
    }
    public function getPriceWithShipping(){
        return number_format(($this->price)/ 100 + $this->shipping, 2);
    }
    public function getOrderItemsForPayPal(){
        $data = [];
        foreach($this->order_items as $order_item){
            $data[] = [
                'name' => $order_item->product->name,
                'price' => $order_item->product->price/100,
                'qty' => $order_item->quantity
            ];
        }

        return $data;
    }
    public function getTotalPrice(){
        $price = 0;
        foreach($this->order_items as $order_item){
            $price += $order_item->product->price * $order_item->quantity;
        }

        return $price/100;
    }
    public function savePrices(){
        $total = 0;
        foreach($this->order_items as $item){
            $total += $item->product->price * $item->quantity;
            $item->price = $item->product->price;
            $item->status = 1;
            $item->save();

            $item->product->quantity -= $item->quantity;
            $item->product->save();
        }

        $this->price = $total/100;
        $this->order_date = Carbon::now();
        $this->save();
    }
    public function addOrderItemsPostAuth($products){
        $products = json_decode($products);

        foreach($products as $product){
            if(!Product::find($product->productID)) continue;

            $order_item = Order_item::where('product_id', $product->productID)->where('order_id', $this->id)->first();
            if(is_object($order_item)){
                $order_item->quantity += $product->quantity;
                $order_item->save();
            }
            else Order_item::create([
                'product_id' => $product->productID,
                'quantity' => $product->quantity,
                'order_id' => $this->id
            ]);
        }
    }
    public function checkQuantities(){
        $messages = [];
        foreach($this->order_items as $order_item){
            if($order_item->quantity > $order_item->product->quantity){
                $messages[] = Lang::get('front.There is only ') . $order_item->product->quantity . ' ' . Lang::get('front.of ') . $order_item->product->name . ' ' . Lang::get('front.left in stock.');
                $order_item->quantity = $order_item->product->quantity;
                $order_item->save();
            }
        }

        return $messages;
    }
    public function getStatusText(){
        switch ($this->status){
            case 1:
                $text = Lang::get('admin.Paid');
                break;
            case 2:
                $text = Lang::get('admin.Shipped');
                break;
            case 3:
                $text = Lang::get('admin.Delivered');
                break;
            default:
                $text = '';
                break;
        }

        return $text;
    }
    public function getIDWithYear(){
        return Carbon::now()->year . $this->id;
    }
}
