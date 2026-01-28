<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        $totalSavings = 0;
        $cartItems = [];
        
        // Synchroniser et mettre à jour les prix des produits
        $cart = $this->syncCartPrices($cart);
        
        foreach ($cart as $id => $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
            
            // Calcul des économies - vérifier si la clé existe
            if (isset($item['has_promotion']) && $item['has_promotion'] && isset($item['original_price'])) {
                $savings = ($item['original_price'] - $item['price']) * $item['quantity'];
                $totalSavings += $savings;
            }
            
            $cartItems[$id] = $item;
        }
        
        // Produits recommandés
        $recommendedProducts = Product::whereHas('promotions', function($query) {
            $query->where('start_date', '<=', now())
                  ->where('end_date', '>=', now());
        })->inRandomOrder()->limit(4)->get();
        
        // Mettre à jour la session avec les données synchronisées
        session()->put('cart', $cart);
        
        return view('cart.index', compact('cartItems', 'subtotal', 'totalSavings', 'recommendedProducts'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::with('promotions')->findOrFail($id);
        
        $cart = session()->get('cart', []);
        
        // Calculer le prix promotionnel
        $price = $this->getDiscountedPrice($product);
        $originalPrice = $product->price;
        $discountPercent = $this->getDiscountPercent($product);
        $hasPromotion = $discountPercent > 0;
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            // Mettre à jour les prix au cas où la promotion aurait changé
            $cart[$id]['price'] = $price;
            $cart[$id]['original_price'] = $originalPrice;
            $cart[$id]['discount_percent'] = $discountPercent;
            $cart[$id]['has_promotion'] = $hasPromotion;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "original_price" => $originalPrice,
                "price" => $price,
                "discount_percent" => $discountPercent,
                "image" => $product->image ?? 'https://via.placeholder.com/150',
                "sku" => $product->sku ?? 'N/A',
                "has_promotion" => $hasPromotion
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Produit ajouté au panier!');
    }

    public function increase($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        }

        return back();
    }

    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return back();
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produit supprimé du panier');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Panier vidé');
    }

    /**
     * Synchronise les prix du panier avec les promotions actuelles
     */
    private function syncCartPrices($cart)
    {
        $updated = false;
        
        foreach ($cart as $id => $item) {
            $product = Product::with('promotions')->find($id);
            
            if ($product) {
                $newPrice = $this->getDiscountedPrice($product);
                $newOriginalPrice = $product->price;
                $newDiscountPercent = $this->getDiscountPercent($product);
                $hasPromotion = $newDiscountPercent > 0;
                
                // Vérifier si le prix a changé ou si les clés manquent
                $needsUpdate = false;
                
                // Vérifier si les clés existent
                if (!isset($item['has_promotion']) || 
                    !isset($item['original_price']) || 
                    !isset($item['discount_percent'])) {
                    $needsUpdate = true;
                }
                // Vérifier si le prix a changé
                else if ($item['price'] != $newPrice) {
                    $needsUpdate = true;
                }
                
                if ($needsUpdate) {
                    $cart[$id]['price'] = $newPrice;
                    $cart[$id]['original_price'] = $newOriginalPrice;
                    $cart[$id]['discount_percent'] = $newDiscountPercent;
                    $cart[$id]['has_promotion'] = $hasPromotion;
                    $updated = true;
                }
            }
        }
        
        // Si des mises à jour ont été faites, informer l'utilisateur
        if ($updated) {
            session()->flash('info', 'Les prix de votre panier ont été mis à jour avec les dernières promotions!');
        }
        
        return $cart;
    }

    /**
     * Calcule le prix après réduction
     */
    private function getDiscountedPrice($product)
    {
        // Si le modèle a la méthode discounted_price
        if (method_exists($product, 'getDiscountedPriceAttribute')) {
            return $product->getDiscountedPriceAttribute();
        }
        
        // Sinon, calculer manuellement
        $discountPercent = $this->getDiscountPercent($product);
        if ($discountPercent > 0) {
            return $product->price * (1 - $discountPercent / 100);
        }
        
        return $product->price;
    }

    /**
     * Calcule le pourcentage de réduction
     */
    private function getDiscountPercent($product)
    {
        // Si le modèle a la méthode discount_percent
        if (method_exists($product, 'getDiscountPercentAttribute')) {
            return $product->getDiscountPercentAttribute();
        }
        
        // Sinon, chercher la promotion active
        if ($product->relationLoaded('promotions')) {
            $promotions = $product->promotions;
        } else {
            $promotions = $product->promotions()->get();
        }
        
        foreach ($promotions as $promotion) {
            if ($promotion->start_date <= now() && $promotion->end_date >= now()) {
                return $promotion->discount_percent;
            }
        }
        
        return 0;
    }

    /**
     * Version publique pour synchroniser les prix (peut être appelée depuis une route)
     */
    public function sync()
    {
        $cart = session()->get('cart', []);
        $updatedCart = $this->syncCartPrices($cart);
        session()->put('cart', $updatedCart);
        
        return back()->with('success', 'Prix synchronisés avec les promotions actuelles');
    }
}