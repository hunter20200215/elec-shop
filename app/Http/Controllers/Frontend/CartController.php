<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class CartController extends Controller{
    public function index(){
        $settings = Setting::first();
        if(Auth::check()){
            $order = Order::where('status', 0)->where('user_id', Auth::user()->id)->first();
            $subtotal = 0;
            foreach($order?->order_items ?? [] as $item) $subtotal += $item->product->price * $item->quantity;

            $total = number_format($subtotal/100 + $settings->shipping, 2);
            $subtotal = number_format($subtotal/100, 2);

            return view('front.carts.cart_logged_in', ['total' => $total, 'order' => $order, 'subtotal' => $subtotal]);
        }

        return view('front.carts.cart_logged_out');
    }
    public function add_item(Request $request){
        $product = Product::find($request->data['id']);

        if($product->quantity < $request->data['quantity'] || $request->data['quantity'] < 1) return response([], 406);

        $order = Order::where('status', 0)->where('user_id', Auth::user()->id)->first();

        if(!is_object($order)) $order = Order::create(['user_id' => Auth::user()->id]);

        $order_item = $order->order_items->firstWhere('product_id', $product->id);

        if($order_item){
            $order_item->quantity += (int) $request->data['quantity'];
            $order_item->save();
        }
        else{
            Order_item::create([
                'product_id' => $product->id,
                'quantity' => $request->data['quantity'],
                'order_id' => $order->id
            ]);
        }

        return response([]);
    }
    public function remove_item(Request $request){
        try{
            $order_item = Order_item::find($request->data['id']);
            $order_id = $order_item->order_id;
            $order_item->delete();
            $order = Order::find($order_id);
            if(count($order->fresh()->order_items) === 0) $order->delete();

        }catch (\Exception $e){
            return response(['error' => 'There was an error.'], 422);
        }

        return response([]);
    }
    public function change_item_quantity(Request $request){
        $change_by = $request->data['type'] === 'increase' ? 1 : -1;
        $order_item = Order_item::find($request->data['id']);
        $order_item->quantity += $change_by;

        if($order_item->quantity > $order_item->product->quantity) return response(['message' => Lang::get('front.There is not enough products in stock!')], 406);
        if($order_item->quantity < 1) return response(['message' => Lang::get('front.Quantity can not be less than 1')], 406);

        $order_item->save();

        return response([]);
    }
    public function render_logged_out_cart(Request $request){
        $data = json_decode($request->data['products']);
        $product_ids = array_column($data, 'productID');
        $products = Product::whereIn('id', $product_ids)->get()->map(function ($product) use ($data) {
            $product['cart_quantity'] = array_values(array_filter($data, fn ($item) => $item->productID === $product->id))[0]->quantity;
            return $product;
        });

        return response([
            'html' => view('front.carts.products_list', ['products' => $products])->render()
        ]);
    }
}
