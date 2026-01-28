<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    // Liste toutes les commandes
    public function index() {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Voir les détails d’une commande
    public function show(Order $order) {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    // Changer le statut
    public function updateStatus(Request $request, Order $order) {
        $request->validate([
            'status' => 'required|in:en cours,expédié,livré'
        ]);

        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Statut mis à jour !');
    }
}

