@extends('client.layouts')

@section('title', 'Catalogue Produits - ShopStore')

@section('content')
<div class="container-fluid py-4">

    <!-- En-tête avec titre et statistiques -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div class="mb-3 mb-md-0">
                    <h1 class="fw-bold mb-2">🎯 Notre Catalogue</h1>
                    <p class="text-muted mb-0">
                        {{ $products->total() }} produits disponibles
                        @if(request()->has('search'))
                            pour "{{ request('search') }}"
                        @endif
                    </p>
                </div>
                
                <div class="d-flex gap-3">
                    <!-- Toggle vue (grille/liste) -->
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="viewMode" id="gridView" autocomplete="off" checked>
                        <label class="btn btn-outline-secondary" for="gridView" onclick="setViewMode('grid')">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </label>
                        
                        <input type="radio" class="btn-check" name="viewMode" id="listView" autocomplete="off">
                        <label class="btn btn-outline-secondary" for="listView" onclick="setViewMode('list')">
                            <i class="bi bi-list-ul"></i>
                        </label>
                    </div>
                    
                    <!-- Toggle sidebar filtres -->
                    <button class="btn btn-outline-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtersOffcanvas">
                        <i class="bi bi-funnel"></i> Filtres
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar des filtres (Desktop) -->
        <div class="col-lg-3 d-none d-lg-block mb-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-funnel me-2"></i>Filtres
                    </h5>
                </div>
                
                <form method="GET" id="filterForm" class="card-body">
                    <!-- Recherche -->
                    <div class="mb-4">
                        <label class="form-label fw-medium mb-2">Recherche</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                   name="search"
                                   class="form-control border-start-0"
                                   placeholder="Nom du produit..."
                                   value="{{ request('search') }}"
                                   onkeyup="debouncedFilter()">
                        </div>
                    </div>
                    
                    <!-- Catégories -->
                    <div class="mb-4">
                        <label class="form-label fw-medium mb-2">Catégories</label>
                        <select name="category_id" class="form-select" onchange="submitFilterForm()">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->products_count ?? 0 }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Prix -->
                    <div class="mb-4">
                        <label class="form-label fw-medium mb-2">Prix</label>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <input type="number" 
                                       name="min_price" 
                                       class="form-control" 
                                       placeholder="Min"
                                       value="{{ request('min_price') }}"
                                       onchange="submitFilterForm()">
                            </div>
                            <div class="col-6">
                                <input type="number" 
                                       name="max_price" 
                                       class="form-control" 
                                       placeholder="Max"
                                       value="{{ request('max_price') }}"
                                       onchange="submitFilterForm()">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">0 DT</small>
                            <small class="text-muted">1000 DT</small>
                        </div>
                    </div>
                    
                    <!-- Trier par -->
                    <div class="mb-4">
                        <label class="form-label fw-medium mb-2">Trier par</label>
                        <select name="sort" class="form-select" onchange="submitFilterForm()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Nouveautés</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Les plus populaires</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Meilleures notes</option>
                        </select>
                    </div>
                    
                    <!-- Disponibilité -->
                    <div class="mb-4">
                        <label class="form-label fw-medium mb-2">Disponibilité</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="in_stock" 
                                   id="inStock"
                                   value="1"
                                   {{ request('in_stock') ? 'checked' : '' }}
                                   onchange="submitFilterForm()">
                            <label class="form-check-label" for="inStock">
                                En stock seulement
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="promo" 
                                   id="promo"
                                   value="1"
                                   {{ request('promo') ? 'checked' : '' }}
                                   onchange="submitFilterForm()">
                            <label class="form-check-label" for="promo">
                                Promotions seulement
                            </label>
                        </div>
                    </div>
                    
                    <!-- Boutons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel me-2"></i>Appliquer les filtres
                        </button>
                        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Bannière promo -->
            <div class="card bg-gradient mt-4 border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <h6 class="fw-bold mb-2">🎁 Offre spéciale</h6>
                    <p class="small mb-3">-20% sur votre première commande avec le code WELCOME20</p>
                    <small class="opacity-75">Valable jusqu'au 31/12/2024</small>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="col-lg-9">
            <!-- Barre de filtres mobiles -->
            <div class="d-flex justify-content-between align-items-center mb-4 d-lg-none">
                <div>
                    <span class="text-muted">{{ $products->total() }} produits</span>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtersOffcanvas">
                        <i class="bi bi-sliders me-1"></i>Filtres & Tri
                    </button>
                </div>
            </div>
            
            <!-- Affichage des produits -->
            <div id="productsGrid" class="view-grid">
                <div class="row g-4">
                    @forelse($products as $product)
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="product-card h-100">
                            <!-- Badges -->
                            <div class="position-relative">
                                <a href="{{ route('client.products.show', $product) }}">
                                    <img src="{{ $product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60' }}" 
                                         class="product-image" 
                                         alt="{{ $product->name }}"
                                         loading="lazy">
                                </a>
                                
                                <div class="product-badges">
                                    @if($product->stock <= 5 && $product->stock > 0)
                                        <span class="badge bg-warning">Derniers</span>
                                    @endif
                                    @if($product->old_price)
                                        <span class="badge bg-danger">Promo</span>
                                    @endif
                                    @if($product->is_new)
                                        <span class="badge bg-success">Nouveau</span>
                                    @endif
                                </div>
                                
                                <!-- Boutons rapides -->
                                <div class="product-actions">
                                    <button class="btn btn-light btn-sm rounded-circle" 
                                            onclick="toggleWishlist({{ $product->id }})"
                                            data-product-id="{{ $product->id }}">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                    <button class="btn btn-light btn-sm rounded-circle" 
                                            onclick="quickView({{ $product->id }})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Corps du produit -->
                            <div class="product-body">
                                <div class="mb-2">
                                    <span class="badge bg-light text-dark small">
                                        {{ $product->category->name ?? 'Général' }}
                                    </span>
                                </div>
                                
                                <h3 class="product-title">
                                    <a href="{{ route('client.products.show', $product) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($product->name, 50) }}
                                    </a>
                                </h3>
                                
                                <!-- Notation -->
                                <div class="d-flex align-items-center mb-2">
                                    <div class="product-rating small me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product->rating ?? 4))
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @elseif($i <= ceil($product->rating ?? 4))
                                                <i class="bi bi-star-half text-warning"></i>
                                            @else
                                                <i class="bi bi-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <small class="text-muted">({{ $product->reviews_count ?? 0 }})</small>
                                </div>
                                
                                <!-- Description courte -->
                                <p class="text-muted small mb-3">
                                    {{ Str::limit($product->short_description ?? $product->description, 80) }}
                                </p>
                                
                                <!-- Prix et actions -->
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div>
                                        <span class="product-price">{{ number_format($product->price, 2) }} DT</span>
                                        @if($product->old_price)
                                            <span class="product-old-price">{{ number_format($product->old_price, 2) }} DT</span>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('client.products.show', $product) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        @if($product->stock > 0)
                                        <form method="POST" action="{{ route('cart.add', $product) }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm add-to-cart-btn">
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                        </form>
                                        @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- État vide -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-search display-1 text-muted mb-4"></i>
                                <h3 class="fw-bold mb-3">Aucun produit trouvé</h3>
                                <p class="text-muted mb-4">
                                    Aucun produit ne correspond à vos critères de recherche.
                                </p>
                                <a href="{{ route('client.dashboard') }}" class="btn btn-primary btn-lg">
                                    <i class="bi bi-arrow-left me-2"></i>Voir tous les produits
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Vue liste (cachée par défaut) -->
            <div id="productsList" class="view-list d-none">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        @forelse($products as $product)
                        <div class="product-list-item border-bottom p-4">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="{{ $product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://via.placeholder.com/150' }}" 
                                         alt="{{ $product->name }}" 
                                         class="img-fluid rounded"
                                         style="height: 120px; object-fit: cover;">
                                </div>
                                <div class="col-md-6">
                                    <h5 class="fw-bold mb-1">
                                        <a href="{{ route('client.products.show', $product) }}" class="text-decoration-none text-dark">
                                            {{ $product->name }}
                                        </a>
                                    </h5>
                                    <p class="text-muted small mb-2">
                                        {{ Str::limit($product->description, 120) }}
                                    </p>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="product-rating small me-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @endfor
                                        </div>
                                        <small class="text-muted">({{ $product->reviews_count ?? 0 }})</small>
                                    </div>
                                    <div>
                                        <span class="badge bg-light text-dark">{{ $product->category->name ?? 'Général' }}</span>
                                        @if($product->stock <= 5 && $product->stock > 0)
                                            <span class="badge bg-warning small">Stock faible</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="mb-3">
                                        <span class="h4 fw-bold text-primary">{{ number_format($product->price, 2) }} DT</span>
                                        @if($product->old_price)
                                            <div class="text-muted text-decoration-line-through small">{{ number_format($product->old_price, 2) }} DT</div>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('client.products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i>Voir
                                        </a>
                                        @if($product->stock > 0)
                                        <form method="POST" action="{{ route('cart.add', $product) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <button class="btn btn-outline-secondary btn-sm" onclick="toggleWishlist({{ $product->id }})">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bi bi-search display-1 text-muted mb-3"></i>
                            <h5 class="fw-bold">Aucun produit trouvé</h5>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-5">
                <nav aria-label="Pagination des produits">
                    {{ $products->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                </nav>
            </div>
            @endif
            
            <!-- Statistiques bas de page -->
            <div class="row mt-5">
                <div class="col-md-4 text-center mb-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <i class="bi bi-truck display-6 text-primary mb-3"></i>
                            <h5 class="fw-bold">Livraison rapide</h5>
                            <p class="text-muted small">Expédition sous 24-48h</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <i class="bi bi-shield-check display-6 text-success mb-3"></i>
                            <h5 class="fw-bold">Paiement sécurisé</h5>
                            <p class="text-muted small">CB, PayPal, 3x sans frais</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <i class="bi bi-arrow-counterclockwise display-6 text-warning mb-3"></i>
                            <h5 class="fw-bold">Satisfait ou remboursé</h5>
                            <p class="text-muted small">30 jours pour changer d'avis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Offcanvas pour filtres mobiles -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="filtersOffcanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold">
            <i class="bi bi-funnel me-2"></i>Filtres & Tri
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form method="GET" id="mobileFilterForm">
            <!-- Recherche -->
            <div class="mb-4">
                <label class="form-label fw-medium mb-2">Recherche</label>
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Nom du produit..."
                       value="{{ request('search') }}">
            </div>
            
            <!-- Catégories -->
            <div class="mb-4">
                <label class="form-label fw-medium mb-2">Catégories</label>
                <select name="category_id" class="form-select">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Prix -->
            <div class="mb-4">
                <label class="form-label fw-medium mb-2">Prix max (DT)</label>
                <input type="range" 
                       class="form-range" 
                       min="0" 
                       max="1000" 
                       step="10"
                       name="max_price"
                       value="{{ request('max_price', 1000) }}"
                       id="mobilePriceRange">
                <div class="d-flex justify-content-between">
                    <small>0 DT</small>
                    <small id="mobilePriceValue">{{ request('max_price', 1000) }} DT</small>
                </div>
            </div>
            
            <!-- Trier par -->
            <div class="mb-4">
                <label class="form-label fw-medium mb-2">Trier par</label>
                <select name="sort" class="form-select">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Nouveautés</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                </select>
            </div>
            
            <!-- Disponibilité -->
            <div class="mb-4">
                <label class="form-label fw-medium mb-2">Disponibilité</label>
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="in_stock" 
                           id="mobileInStock"
                           value="1"
                           {{ request('in_stock') ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobileInStock">
                        En stock seulement
                    </label>
                </div>
            </div>
            
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary" data-bs-dismiss="offcanvas">
                    <i class="bi bi-check-lg me-2"></i>Appliquer
                </button>
                <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Réinitialiser
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickViewTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="quickViewContent">
                <!-- Contenu chargé via AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- Styles additionnels -->
<style>
    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s;
        border: 1px solid #e5e7eb;
        height: 100%;
        position: relative;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-color);
    }
    
    .product-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
        transition: transform 0.3s;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-badges {
        position: absolute;
        top: 10px;
        left: 10px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        z-index: 10;
    }
    
    .product-badges .badge {
        padding: 0.35rem 0.75rem;
        font-weight: 600;
        border-radius: 20px;
    }
    
    .product-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .product-card:hover .product-actions {
        opacity: 1;
    }
    
    .product-actions button {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .product-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        height: calc(100% - 200px);
    }
    
    .product-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark-color);
        line-height: 1.4;
    }
    
    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .product-old-price {
        font-size: 0.9rem;
        color: #9ca3af;
        text-decoration: line-through;
        margin-right: 0.5rem;
    }
    
    .product-rating {
        color: #f59e0b;
    }
    
    .product-list-item:hover {
        background-color: rgba(99, 102, 241, 0.03);
    }
    
    .add-to-cart-btn:hover {
        animation: bounce 0.3s ease-in-out;
    }
    
    @keyframes bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(0.95); }
    }
    
    .sticky-top {
        position: -webkit-sticky;
        position: sticky;
    }
    
    .view-list .product-list-item:last-child {
        border-bottom: none !important;
    }
    
    /* Animation pour le changement de vue */
    .view-grid, .view-list {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du mode de vue
        const viewMode = localStorage.getItem('viewMode') || 'grid';
        setViewMode(viewMode);
        
        // Mettre à jour les boutons radio
        if (viewMode === 'grid') {
            document.getElementById('gridView').checked = true;
        } else {
            document.getElementById('listView').checked = true;
        }
        
        // Range slider mobile
        const mobilePriceRange = document.getElementById('mobilePriceRange');
        const mobilePriceValue = document.getElementById('mobilePriceValue');
        
        if (mobilePriceRange && mobilePriceValue) {
            mobilePriceRange.addEventListener('input', function() {
                mobilePriceValue.textContent = this.value + ' DT';
            });
        }
        
        // Gestion des boutons d'ajout au panier
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('form');
                if (form) {
                    // Animation du bouton
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-check-lg"></i>';
                    this.classList.add('btn-success');
                    this.classList.remove('btn-primary');
                    this.disabled = true;
                    
                    // Soumettre le formulaire après animation
                    setTimeout(() => {
                        form.submit();
                    }, 300);
                }
            });
        });
        
        // Gestion des wishlists
        window.toggleWishlist = function(productId) {
            const button = document.querySelector(`button[data-product-id="${productId}"]`);
            if (button) {
                const isActive = button.classList.contains('btn-danger');
                
                if (isActive) {
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-light');
                    button.innerHTML = '<i class="bi bi-heart"></i>';
                    showToast('Retiré des favoris', 'info');
                } else {
                    button.classList.remove('btn-light');
                    button.classList.add('btn-danger');
                    button.innerHTML = '<i class="bi bi-heart-fill"></i>';
                    showToast('Ajouté aux favoris', 'success');
                }
            }
        };
        
        // Quick view (simulé)
        window.quickView = function(productId) {
            // Pour l'exemple, on simule juste le modal
            const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            document.getElementById('quickViewTitle').textContent = 'Aperçu rapide';
            document.getElementById('quickViewContent').innerHTML = `
                <div class="text-center py-4">
                    <i class="bi bi-info-circle display-1 text-muted mb-3"></i>
                    <p>Cette fonctionnalité chargerait les détails du produit ${productId} via AJAX.</p>
                </div>
            `;
            modal.show();
        };
        
        // Debounce pour la recherche
        let debounceTimer;
        window.debouncedFilter = function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                submitFilterForm();
            }, 500);
        };
        
        // Fonction pour soumettre le formulaire de filtres
        window.submitFilterForm = function() {
            document.getElementById('filterForm').submit();
        };
        
        // Fonction pour changer le mode de vue
        window.setViewMode = function(mode) {
            const gridView = document.getElementById('productsGrid');
            const listView = document.getElementById('productsList');
            
            if (mode === 'grid') {
                gridView.classList.remove('d-none');
                gridView.classList.add('view-grid');
                listView.classList.add('d-none');
            } else {
                gridView.classList.add('d-none');
                listView.classList.remove('d-none');
                listView.classList.add('view-list');
            }
            
            localStorage.setItem('viewMode', mode);
        };
        
        // Fonction toast
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 end-0 p-3';
            toast.style.zIndex = '1060';
            
            const bgColor = type === 'success' ? 'bg-success' : 
                           type === 'error' ? 'bg-danger' : 
                           type === 'warning' ? 'bg-warning' : 'bg-primary';
            
            toast.innerHTML = `
                <div class="toast show" role="alert">
                    <div class="toast-header ${bgColor} text-white border-0">
                        <i class="bi ${type === 'success' ? 'bi-check-circle' : 
                                       type === 'error' ? 'bi-exclamation-circle' : 
                                       type === 'warning' ? 'bi-exclamation-triangle' : 'bi-info-circle'} me-2"></i>
                        <strong class="me-auto">${type === 'success' ? 'Succès' : 
                                                  type === 'error' ? 'Erreur' : 
                                                  type === 'warning' ? 'Attention' : 'Information'}</strong>
                        <button type="button" class="btn-close btn-close-white" onclick="this.closest('.toast').remove()"></button>
                    </div>
                    <div class="toast-body bg-light">
                        ${message}
                    </div>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 3000);
        }
        
        // Animation au chargement
        document.querySelectorAll('.product-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s, transform 0.5s';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Mettre à jour le compteur de résultats en temps réel
        const resultCount = {{ $products->total() }};
        const countElement = document.querySelector('.text-muted.mb-0');
        if (countElement && resultCount > 0) {
            // Animation du compteur
            let currentCount = 0;
            const counter = setInterval(() => {
                currentCount += Math.ceil(resultCount / 20);
                if (currentCount >= resultCount) {
                    currentCount = resultCount;
                    clearInterval(counter);
                }
                countElement.textContent = `${currentCount} produits disponibles`;
            }, 50);
        }
    });
</script>
@endsection