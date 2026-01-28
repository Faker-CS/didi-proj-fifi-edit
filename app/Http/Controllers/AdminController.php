<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Promotion;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class AdminController extends Controller
{   
   public function dashboard()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();

        return view('admin.dashboard', compact('products', 'categories'));
    }

        // Afficher tous les produits
   public function products(Request $request)
{
    $query = Product::with('category');

    if ($request->has('category_id') && !empty($request->category_id)) {
        $query->where('category_id', $request->category_id);
    }

    $products = $query->get();
    $categories = Category::all(); // si tu affiches la liste ailleurs

    return view('admin.products', compact('products', 'categories'));
}


    // Afficher toutes les catégories
    public function categories()
        {
            return view('admin.categories', ['categories' => Category::all()]);
        }
    // Stocker une nouvelle catégorie
        public function storeCategory(Request $request)
        {
            $request->validate(['name' => 'required|string|max:255|unique:categories,name', ]);
             Category::create(['name' => $request->name,]);
            return redirect()->back()->with('success', 'Catégorie ajoutée avec succès');
        }
    


    // Éditer un produit
    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('admin.edit_product', compact('product', 'categories'));
    }

    // Mettre à jour le produit
    public function updateProduct(Request $request, Product $product)
    {
     
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|url',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $request->image,
        ]);

        return redirect()->back()->with('success', 'Modification enregistrée');

    }

    // Supprimer un produit
    public function destroyProduct(Product $product)
    {
        // Supprimer l’image si elle existe
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produit supprimé !');
    }
    // Page création produit
public function createProduct()
{
    $categories = Category::all(); // Pour le select
    return view('admin.create_product', compact('categories'));
}

    // Stocker le produit
    public function storeProduct(Request $request)
    {
        $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'nullable|exists:categories,id',
                'image' => 'nullable|url'
            ]);

                $product = new Product(); // pour create
                // ou $product = Product::find($id); // pour update

                $product->name = $request->name;
                $product->description = $request->description;
                $product->price = $request->price;
                $product->stock = $request->stock;
                $product->category_id = $request->category_id;
                $product->image=$request->image;

                $product->save();

        return redirect()->back()->with('success', 'Produit ajouté avec succès');
    }



    //Ajouter une promotion
    public function createPromotion()
    {
        $products = Product::all();
        return view('admin.promotions.create', compact('products'));
    }

    public function storePromotion(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percent' => 'required|integer|min:1|max:90',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Promotion::create($request->all());

        return redirect()->route('admin.dashboard')
            ->with('success', 'Promotion ajoutée avec succès');
    }

    //page analytics
    public function analytics()
    {
        return view('admin.analytics', [
            'productsCount' => Product::count(),
            'categoriesCount' => Category::count(),
            'clientsCount' => User::where('role', 'client')->count(),
            'ordersCount' => Order::count(),

            'ordersToday' => Order::whereDate('created_at', Carbon::today())->count(),
            'ordersMonth' => Order::whereMonth('created_at', Carbon::now()->month)->count(),

            'totalRevenue' => Order::sum('total'),

            'topProducts' => OrderItem::selectRaw('product_id, SUM(quantity) as total_qty')
                ->groupBy('product_id')
                ->orderByDesc('total_qty')
                ->with('product')
                ->take(5)
                ->get()
        ]);
    }
}


