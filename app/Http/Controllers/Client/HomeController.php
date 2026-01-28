<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;


class HomeController extends Controller
{
     public function index()
    {
        $products = Product::with('category')->get();

        return view('client.dashboard', compact('products'));
    }
}
