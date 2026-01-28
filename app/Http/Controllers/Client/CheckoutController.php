<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('client.checkout');
    }

    public function store(Request $request)
    {
        

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Panier vide');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'payment_method' => $request->payment_method,
            'status' => 'en cours',
        ]);

        $cart = session('cart');

        foreach ($cart as $productId => $item) {
        OrderItem::create([
        'order_id'  => $order->id,
        'product_id'=> $productId, // ✅ ICI
        'price'     => $item['price'],
        'quantity'  => $item['quantity'],
    ]);
}

        session()->forget('cart');

        return view('client.order_success', compact('order'));
    }
}
