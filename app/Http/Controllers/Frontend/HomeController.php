<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Attribute;
use App\Models\Attribute_value;
use App\Models\Category;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index(Request $request){
        // Arrays needed for filters
        $selected_categories = array_filter(explode(',', $request->categories)) ?? [];
        $selected_attribute_values = array_filter(explode(',', $request->attributeValues)) ?? [];
        $grouped_values = Attribute_value::whereIn('id', $selected_attribute_values)->get()->groupBy('attribute_id');
        $selected_sort_option = '';

        // Loading products
        $products = Product::select('products.*')
            ->published()
            ->trending($request->getPathInfo() === '/trending')
            ->inCategories($selected_categories)
            ->maxPrice($request->max ?? null)
            ->minPrice($request->min ?? null)
            ->isCalled($request->searchTerm ?? null);

        if($request->sortBy && $request->sortDirection){
            $products->orderBy($request->sortBy, $request->sortDirection);
            $selected_sort_option = "{$request->sortBy}_{$request->sortDirection}";
        }

        foreach($grouped_values as $key => $value) $products->hasAttributeValue($key, $value->pluck('id')->toArray());

        $products = $products->cursorPaginate(20)->withQueryString();

        if(isset($_GET['api'])){
            return response([
                'html' => view('front.partials.products_list', ['products' => $products])->render(),
                'href' => $products->nextPageUrl()
            ]);
        }

        $categories = Category::withCount('products')->get();
        $featured_categories = Category::featured()->get();
        $attributes = Attribute::with('attribute_values')->visibleOnSearch()->get();
        $index_type = $request->getPathInfo();

        return view('front.index', [
            'products' => $products,
            'attributes' => $attributes,
            'categories' => $categories,
            'featured_categories' => $featured_categories,
            'min' => floor($products->min('price') / 1000) * 1000,
            'max' => ceil($products->max('price') / 1000) * 1000,
            'selected_categories' => $selected_categories,
            'selected_attribute_values' => $selected_attribute_values,
            'index_type' => $index_type,
            'selected_sort_option' => $selected_sort_option
        ]);
    }
    public function page(Page $page){
        return view('front.page', ['page' => $page]);
    }
    /*public function about_us(){
        return view('front.about_us');
    }*/
    public function contact_us(){
        return view('front.contact_us');
    }
    public function contact_us_post(Request $request){
        $rules = ['message' =>'required', ];
        if(!Auth::check()) $rules += ['first_name' => 'required', 'last_name' => 'required', 'email' => 'required'];
        $request->validate($rules);

        $settings = Setting::first();

        $data = [
            'full_name' => Auth::user()?->full_name ?? "$request->first_name $request->last_name",
            'email' => Auth::user()?->email ?? $request->email,
            'message' => $request->message
        ];

        $request['contact-title'] ?? Mail::to($settings->email)->queue(new ContactMail($data));

        return redirect()->back()->with('message', Lang::get('session_messages.Thank you for contacting Genesis Bricks. We will reply to the email address you have on file.'));
    }
    public function product(Product $product){
        $attribute_values = Attribute_value::join('product_attribute_values as pav', 'pav.attribute_value_id', 'attribute_values.id')
            ->join('attributes', 'attributes.id', 'attribute_values.attribute_id')
            ->where('pav.product_id', $product->id)
            ->with('attribute')
            ->get();

        $related_products = Product::where('category_id',  $product->category_id)->where('id', '!=', $product->id)->published()->get();

        return view('front.product', ['product' => $product, 'attribute_values' => $attribute_values, 'related_products' => $related_products]);
    }
    public function my_account(){
        $user = Auth::user();
        return view('front.my_account', ['user' => $user]);
    }
    public function update_my_account(Request $request){
        $user = Auth::user();
        $request->validate([
            'full_name' => 'required',
            'email'=> 'required|email|unique:users,email,' . $user->id,
            'password'=> 'nullable|confirmed|min:8',
        ]);

        if (!$request['password']){
            $user->update($request->except('password', 'password_confirmation', 'roles'));
        }
        else {
            $request->merge(['password' => bcrypt($request->password)]);
            $user->update($request->all());
        }

        if(array_key_exists('email', $user->getChanges())){
            $user->email_verified_at = null;
            $user->save();
            $user->sendEmailVerificationNotification();
        }

        return redirect('/my-account')->with('message', Lang::get('session_messages.Profile successfully updated!'));
    }
    public function my_orders(){
        $orders = Order::where('user_id', Auth::user()->id)->where('status', '<>', 0)->orderBy('id', 'desc')->with('order_items', 'order_items.product')->get();

        return view('front.my_orders', ['orders' => $orders]);
    }
    public function unsubscribe(){
        return view('front.unsubscribe');
    }
    public function unsubscribe_post(){
        $user = Auth::user();
        $user->unsubscribed = 1;
        $user->save();

        return redirect(RouteServiceProvider::HOME)->with('message', Lang::get('session_messages.You have successfully unsubscribed from all emails.'));
    }
}
