<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_attribute_value;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    private string $menu;
    public function __construct(){
        $this->menu = 'products';
    }

    public function index(){
        $products = Product::with('category')->isCalled($_GET['name'] ?? '')->paginate(50);
        $draft = Product::where('name', 'Draft')->first();

        return view('admin.products.index', ['products' => $products, 'menu' => $this->menu, 'draft' => $draft]);
    }
    public function create(){
        $product = Product::create([
            'name' => 'Draft',
            'price' => 0,
            'slug' => 'draft',

        ]);
        return redirect()->route('admin.products.edit', ['id' => $product->id]);
    }
    public function edit(int $id){
        $product = Product::find($id);
        $categories = Category::all();
        $attributes = Attribute::all();

        return view('admin.products.edit', ['product' => $product, 'categories' => $categories, 'attributes' => $attributes, 'menu' => $this->menu]);
    }
    public function update(Request $request, int $id){
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['numeric', 'min:0'],
            'category_id' => ['required_if:published,==,1'],
        ]);
        
        Product_attribute_value::where('product_id', $id)->delete();
        $product = Product::find($id);
        $request->price *= 100;

        $request->merge(['slug' => Str::slug($request['name'])]);
        $product->update($request->except('attribute_values'));

        $data = [];
        foreach($request->attribute_values as $attribute_value_id){
            if($attribute_value_id) {
                $data[] = ['product_id' => $id, 'attribute_value_id' => $attribute_value_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
            }
        }
        Product_attribute_value::insert($data);

        return redirect()->route('admin.products.index')->with('message', Lang::get('session_messages.Product successfully updated!'));
    }
    public function destroy(int $id){
        Product::destroy($id);
        return redirect()->route('admin.products.index')->with('message', Lang::get('session_messages.Product successfully deleted!'));;
    }
    public function copy(int $id){
        $product = Product::find($id)->load('product_attribute_values', 'model_images');
        $count = Product::where('name', 'iLike', "$product->name%")->count();

        $new_product = $product->replicate();
        $new_product->name .= " Copy($count)";
        $new_product->slug = Str::slug($new_product->name);
        $new_product->published = 0;
        $new_product->push();

        foreach($product->getRelations() as $relation => $items){
            foreach($items as $item){
                unset($item->id);
                $new_product->{$relation}()->create($item->toArray());
            }
        }

        return redirect()->route('admin.products.index')->with('message', Lang::get('session_messages.Product successfully copied!'));
    }
    public function products_stockroom(){
        $products = Product::with('category')->isCalled($_GET['name'] ?? '')->paginate(50);

        return view('admin.products.stockroom', ['products' => $products, 'menu' => $this->menu]);
    }
}
