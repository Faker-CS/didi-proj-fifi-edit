<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    protected $fillable = ['name', 'description', 'price', 'category_id', 'stock'];
    

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->get();

        return view('admin.products', compact('products'));
    }



    public function show(Product $product) {
        return view('products.show', compact('product'));
    }
}



