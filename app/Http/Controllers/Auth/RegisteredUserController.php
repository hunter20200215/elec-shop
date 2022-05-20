<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('front.auth');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validateWithBag('register', [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', 'customer')->first();
        $user->assignRole($role);

        event(new Registered($user));

        Auth::login($user);

        if($request->products){
            $order = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();
            if(!is_object($order)) $order = Order::create(['user_id' => Auth::user()->id]);

            $order->addOrderItemsPostAuth($request->products);

            return redirect(route('cart', ['postAuth']));
        }

        return redirect(RouteServiceProvider::HOME)->with('message', Lang::get('session_messages.Thank you for signing up! We sent you a confirmation email from Genesis Bricks. Please click on the confirmation lin in the email so you can receive transaction notifications and order shipment notifications.'));
    }
}
