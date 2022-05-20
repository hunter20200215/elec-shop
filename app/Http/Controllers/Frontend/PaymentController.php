<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaymentController extends Controller
{
    public function handle_payment(Request $request){
        $settings = Setting::first();

        $order = Order::where('user_id', Auth::user()->id)->where('status', 0)->orderBy('created_at', 'desc')->first();

        $errors = $order->checkQuantities();
        if(sizeof($errors) > 0){
            return redirect()->back()->with('quantityErrors', $errors);
        }
        $order->note = $request->note;
        $order->shipping = $settings->shipping;
        $order->save();

        $provider = new ExpressCheckout;
        $options = [
            'BRANDNAME' => $settings->name,
            'LOGOIMG' => Storage::url($settings->logo),
            'CHANNELTYPE' => 'Merchant'
        ];

        try{
            $response = $provider->addOptions($options)->setExpressCheckout($this->makeDataArrayForPayPal($order));

            return redirect($response['paypal_link']);
        }catch (\Exception $exception){
            return redirect()->back()->with('error', Lang::get('front.There was an error'));
        }
    }
    public function post_payment(Request $request){

        if(!$request->token) return App::abort(404);

        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtolower($response['ACK']), ['success', 'successwithwarning'])){
            $order = Order::find($response['INVNUM']);

            $response = $provider->doExpressCheckoutPayment($this->makeDataArrayForPayPal($order), $request->token, $request->PayerID);

            if (in_array(strtolower($response['ACK']), ['success', 'successwithwarning'])){
                $settings = Setting::first();

                $order->status = 1;
                $order->save();
                $order->savePrices();

                if(Auth::user()->unsubscribed == 0) {
                    Mail::to(Auth::user()->email)->queue(
                        new OrderMail(
                            $order,
                            $settings,
                            Auth::user(),
                            'client_email',
                            Auth::user()->full_name . ' ' . Lang::get('email.Has Purchased from') . " $settings->name " . Lang::get('email.Order') . " $order->id"
                        )
                    );
                }
                Mail::to($settings->email)->queue(
                    new OrderMail(
                        $order,
                        $settings,
                        Auth::user(),
                        'owner_email',
                        Lang::get('New Order Received!') . " $order->id " .Lang::get('email.from') . " $settings->name!"
                    )
                );

                return redirect(route('payments.success'));
            }
        }

        return redirect(route('payments.error'));
    }
    public function payment_error(){
        return view('front.payment_messages.payment_info', [
            'text' => Lang::get('front.There was an error with your payment, please make your order again or contact us if this issue persists.')
        ]);
    }
    public function payment_success(){
        if(!Auth::user()) App::abort(404);

        return view('front.payment_messages.payment_success');
    }
    public function payment_cancel(){
        return view('front.payment_messages.payment_info', [
            'text' => Lang::get('front.You have canceled your payment.')
        ]);
    }
    public function makeDataArrayForPayPal($order){
        $product = [];
        $product['items'] = $order->getOrderItemsForPayPal();

        $product['invoice_id'] = $order->id;
        $product['invoice_description'] = "Order #{$order->getIDWithYear()}";
        $product['return_url'] = route('payments.post_payment');
        $product['cancel_url'] = route('payments.cancel');
        $product['subtotal'] = $order->getTotalPrice();
        $product['total'] = $order->getTotalPrice() + $order->shipping;
        $product['shipping'] = (int) $order->shipping;

        return $product;
    }
}
