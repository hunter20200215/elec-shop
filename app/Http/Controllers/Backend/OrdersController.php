<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    private string $menu;
    public function __construct(){
        $this->menu = 'orders';
    }

    public function index(){
        $orders = Order::where('status', '<>', 0)->orderBy('id', 'desc')->with('user')->paginate(10);

        return view('admin.orders.index', ['orders' => $orders, 'menu' => $this->menu]);
    }

    public function destroy($id){
        Order::destroy($id);
        return redirect()->route('admin.orders.index')->with('message', Lang::get('session_messages.Order successfully deleted!'));
    }

    public function change_status(Request $request){
        $order = Order::find($request->data['id']);
        $order->status = $request->data['status'];
        $order->save();

        $client = User::find($order->user_id);
        $settings = Setting::first();

        if($request->data['status'] == 2){
            if($client->unsubscribed == 0) {
                Mail::to($client->email)->queue(
                    new OrderMail(
                        $order,
                        $settings,
                        $client,
                        'status_email',
                        "$settings->name " . Lang::get('email.Order') . " {$order->getIDWithYear()} " . Lang::get('email.Has been Shipped!'),
                        'transactions@genesisbricks.com'
                    )
                );
            }
            Mail::to($settings->email)->queue(
                new OrderMail(
                    $order,
                    $settings,
                    $client,
                    'status_email',
                    "$settings->name " . Lang::get('email.Order') .  " {$order->getIDWithYear()} " . Lang::get('email.Has been Shipped!'),
                    'transactions@genesisbricks.com'
                )
            );
        }

        return response([]);
    }

}
