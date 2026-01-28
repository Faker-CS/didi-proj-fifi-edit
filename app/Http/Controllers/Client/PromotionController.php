<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        // Trier si un paramètre est passé
        $sort = $request->query('sort', null);
        $promotionsQuery = Promotion::with('product.category');

        switch ($sort) {
            case 'discount_desc':
                $promotionsQuery->orderBy('discount_percent', 'desc');
                break;
            case 'price_asc':
                $promotionsQuery->join('products', 'promotions.product_id', '=', 'products.id')
                                ->orderBy('products.price', 'asc')
                                ->select('promotions.*');
                break;
            case 'price_desc':
                $promotionsQuery->join('products', 'promotions.product_id', '=', 'products.id')
                                ->orderBy('products.price', 'desc')
                                ->select('promotions.*');
                break;
            case 'end_date':
                $promotionsQuery->orderBy('end_date', 'asc');
                break;
        }

        // Toutes les promotions paginées
        $promotions = $promotionsQuery->paginate(12);

        // Promotions phares : plus de 20% de réduction et fin dans 7 jours
        $featuredPromotions = Promotion::with('product.category')
            ->where('discount_percent', '>=', 20)
            ->whereDate('end_date', '>=', now())
            ->orderBy('discount_percent', 'desc')
            ->take(6)
            ->get();

        return view('client.promotion', compact('promotions', 'featuredPromotions'));
    }
}
