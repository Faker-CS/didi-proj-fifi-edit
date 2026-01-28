<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionadminController extends Controller
{
    

public function create()
{
    $products = Product::all();
    $promotions = Promotion::with('product')->orderBy('end_date', 'desc')->get();

    return view('admin.promotions.create', compact('products', 'promotions'));
}
}
