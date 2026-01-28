@extends('client.layouts')

@section('title', $product->name . ' - ShopStore')

@section('content')
<div class="container-fluid py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('client.dashboard') }}" class="text-decoration-none text-primary">
                    <i class="bi bi-house"></i> Accueil
                </a>
            </li>
            @if($product->category)
            <li class="breadcrumb-item">
                <a href="{{ route('client.dashboard', ['category' => $product->category->id]) }}" 
                   class="text-decoration-none text-primary">
                    {{ $product->category->name }}
                </a>
            </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 30) }}</li>
        </ol>
    </nav>

    <!-- Produit principal -->
    <div class="row mb-5">
        <!-- Galerie d'images -->
        <div class="col-lg-6 mb-4">
            <div class="product-gallery">
                <!-- Image principale -->
                <div class="main-image-container mb-3">
                    <img id="mainProductImage" 
                         src="{{ $product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded-3 shadow-sm"
                         data-zoomable>
                    @if($product->stock <= 5 && $product->stock > 0)
                        <span class="product-badge badge-warning">Derniers articles</span>
                    @elseif($product->stock > 5)
                        <span class="product-badge badge-success">En stock</span>
                    @endif
                </div>
                
                <!-- Miniatures -->
                <div class="thumbnail-container d-flex gap-2 overflow-auto pb-2">
                    @php
                        $images = [$product->image];
                        if(isset($product->images)) {
                            $images = array_merge($images, json_decode($product->images, true) ?? []);
                        }
                    @endphp
                    
                    @foreach(array_slice($images, 0, 5) as $index => $img)
                        <img src="{{ Str::startsWith($img, 'http') ? $img : asset('storage/' . $img) }}" 
                             alt="{{ $product->name }} - vue {{ $index + 1 }}" 
                             class="thumbnail rounded-2 {{ $index === 0 ? 'active' : '' }}"
                             width="80"
                             height="80"
                             style="object-fit: cover; cursor: pointer;"
                             onclick="changeMainImage(this)">
                    @endforeach
                </div>
            </div>
            
            <!-- Informations complémentaires -->
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3"><i class="bi bi-info-circle me-2"></i>Caractéristiques</h6>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Référence</small>
                            <strong>{{ $product->sku ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Catégorie</small>
                            <strong>{{ $product->category->name ?? '—' }}</strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Marque</small>
                            <strong>{{ $product->brand ?? 'ShopStore' }}</strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Poids</small>
                            <strong>{{ $product->weight ?? '—' }} kg</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations produit -->
        <div class="col-lg-6">
            <div class="product-details">
                <!-- Titre et notation -->
                <div class="mb-3">
                    <h1 class="fw-bold mb-2">{{ $product->name }}</h1>
                    <div class="d-flex align-items-center gap-3">
                        <div class="product-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($product->rating ?? 4.5))
                                    <i class="bi bi-star-fill text-warning"></i>
                                @elseif($i <= ceil($product->rating ?? 4.5))
                                    <i class="bi bi-star-half text-warning"></i>
                                @else
                                    <i class="bi bi-star text-warning"></i>
                                @endif
                            @endfor
                            <span class="ms-2 text-muted">({{ $product->reviews_count ?? 42 }} avis)</span>
                        </div>
                        <span class="text-success small">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ $product->orders_count ?? 156 }} ventes
                        </span>
                    </div>
                </div>

                <!-- Prix -->
                <div class="mb-4">
                    <div class="d-flex align-items-baseline gap-2">
                        <h2 class="text-primary fw-bold mb-0">{{ number_format($product->price, 2) }} DT</h2>
                        @if($product->old_price)
                            <span class="text-muted text-decoration-line-through fs-5">{{ number_format($product->old_price, 2) }} DT</span>
                            <span class="badge bg-danger ms-2">-{{ round((1 - $product->price / $product->old_price) * 100) }}%</span>
                        @endif
                    </div>
                    <small class="text-muted">TVA incluse</small>
                </div>

                <!-- État du stock -->
                <div class="mb-4">
                    @if($product->stock > 0)
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-success me-2">En stock</span>
                            <small class="text-muted">
                                @if($product->stock > 10)
                                    Plus de 10 articles disponibles
                                @elseif($product->stock > 5)
                                    {{ $product->stock }} articles disponibles
                                @else
                                    Derniers {{ $product->stock }} articles !
                                @endif
                            </small>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            @php
                                $stockPercentage = min(100, ($product->stock / 50) * 100);
                            @endphp
                            <div class="progress-bar bg-success" 
                                 role="progressbar" 
                                 style="width: {{ $stockPercentage }}%"
                                 aria-valuenow="{{ $stockPercentage }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100"></div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Ce produit est actuellement en rupture de stock.
                        </div>
                    @endif
                </div>

                <!-- Options (si disponibles) -->
                @if(isset($product->options))
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2">Options disponibles</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(json_decode($product->options, true) ?? [] as $option)
                            <button type="button" class="btn btn-outline-secondary btn-sm">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quantité et ajout au panier -->
                <div class="mb-5">
                    <form method="POST" action="{{ route('cart.add', $product) }}" id="addToCartForm">
                        @csrf
                        
                        @if($product->stock > 0)
                            <div class="row g-3 align-items-center mb-4">
                                <div class="col-auto">
                                    <label for="quantity" class="col-form-label fw-semibold">Quantité</label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group" style="width: 140px;">
                                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="number" 
                                               name="quantity" 
                                               id="quantity" 
                                               class="form-control text-center" 
                                               value="1" 
                                               min="1" 
                                               max="{{ $product->stock }}">
                                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <small class="text-muted">Max: {{ $product->stock }}</small>
                                </div>
                            </div>
                            
                            <div class="d-flex flex-wrap gap-3">
                                <button type="submit" class="btn btn-primary btn-lg px-5 flex-grow-1" id="addToCartBtn">
                                    <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                                </button>
                                
                                <button type="button" class="btn btn-outline-primary btn-lg" id="wishlistBtn">
                                    <i class="bi bi-heart"></i>
                                    <span class="d-none d-md-inline ms-1">Favoris</span>
                                </button>
                            </div>
                        @else
                            <button type="button" class="btn btn-secondary btn-lg w-100" disabled>
                                <i class="bi bi-bell me-2"></i>Prévenir quand disponible
                            </button>
                        @endif
                    </form>
                </div>

                <!-- Garanties et services -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="bi bi-truck text-primary fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Livraison</small>
                                <strong>Gratuite dès 49DT</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="bi bi-arrow-counterclockwise text-primary fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Retours</small>
                                <strong>30 jours satisfait ou remboursé</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="bi bi-shield-check text-primary fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Paiement</small>
                                <strong>Sécurisé SSL</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="bi bi-headset text-primary fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Support</small>
                                <strong>7j/7 par chat</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description détaillée -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <ul class="nav nav-tabs card-header-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button">
                                <i class="bi bi-file-text me-2"></i>Description
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button">
                                <i class="bi bi-gear me-2"></i>Caractéristiques
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button">
                                <i class="bi bi-star me-2"></i>Avis ({{ $product->reviews_count ?? 0 }})
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="productTabsContent">
                        <!-- Description -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="product-description">
                                {!! $product->description ? nl2br(e($product->description)) : '<p class="text-muted">Aucune description disponible pour ce produit.</p>' !!}
                            </div>
                        </div>
                        
                        <!-- Caractéristiques -->
                        <div class="tab-pane fade" id="specs" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 200px;">Référence</th>
                                            <td>{{ $product->sku ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Marque</th>
                                            <td>{{ $product->brand ?? 'ShopStore' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Dimensions</th>
                                            <td>{{ $product->dimensions ?? '—' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Poids</th>
                                            <td>{{ $product->weight ?? '—' }} kg</td>
                                        </tr>
                                        <tr>
                                            <th>Matériau</th>
                                            <td>{{ $product->material ?? '—' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Couleur</th>
                                            <td>{{ $product->color ?? '—' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Avis -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="reviews-container">
                                @if($product->reviews_count && $product->reviews_count > 0)
                                    <!-- Note moyenne -->
                                    <div class="text-center mb-4">
                                        <div class="display-4 fw-bold text-primary">{{ number_format($product->rating ?? 4.5, 1) }}</div>
                                        <div class="product-rating mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($product->rating ?? 4.5))
                                                    <i class="bi bi-star-fill text-warning fs-4"></i>
                                                @elseif($i <= ceil($product->rating ?? 4.5))
                                                    <i class="bi bi-star-half text-warning fs-4"></i>
                                                @else
                                                    <i class="bi bi-star text-warning fs-4"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="text-muted">Basé sur {{ $product->reviews_count ?? 0 }} avis clients</p>
                                    </div>
                                    
                                    <!-- Avis clients (simulés) -->
                                    <div class="review-list">
                                        @foreach(range(1, 3) as $review)
                                            <div class="review-item border-bottom pb-4 mb-4">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div>
                                                        <strong>Client {{ $review }}</strong>
                                                        <div class="product-rating small">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="bi bi-star-fill text-warning"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">Il y a {{ $review }} semaine(s)</small>
                                                </div>
                                                <p class="mb-0">Excellent produit, je recommande ! La qualité est au rendez-vous.</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="text-center">
                                        <button class="btn btn-outline-primary">Voir tous les avis</button>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="bi bi-chat-square-text display-1 text-muted mb-3"></i>
                                        <h5 class="fw-bold mb-2">Aucun avis pour le moment</h5>
                                        <p class="text-muted mb-4">Soyez le premier à donner votre avis sur ce produit !</p>
                                        <button class="btn btn-primary">Donner mon avis</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produits similaires -->
    @if($relatedProducts->count())
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="fw-bold mb-4">✨ Produits similaires</h2>
            <div class="row g-4">
                @foreach($relatedProducts as $item)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="product-card h-100">
                        <div class="position-relative">
                            <a href="{{ route('client.products.show', $item) }}">
                                <img src="{{ $item->image ? (Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60' }}" 
                                     class="product-image" 
                                     alt="{{ $item->name }}">
                            </a>
                            @if($item->stock <= 5 && $item->stock > 0)
                                <span class="product-badge badge-warning">Derniers</span>
                            @endif
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">
                                <a href="{{ route('client.products.show', $item) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($item->name, 50) }}
                                </a>
                            </h5>
                            <div class="d-flex align-items-center mb-2">
                                <span class="product-rating small">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                    <span class="ms-1 text-muted">(4.0)</span>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="product-price">{{ number_format($item->price, 2) }} DT</span>
                                    @if($item->old_price)
                                        <span class="product-old-price">{{ number_format($item->old_price, 2) }} DT</span>
                                    @endif
                                </div>
                                @if($item->stock > 0)
                                <form method="POST" action="{{ route('cart.add', $item) }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary-client btn-sm">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Vue récemment consultés -->
    <div class="row">
        <div class="col-12">
            <h2 class="fw-bold mb-4">👁️ Récemment consultés</h2>
            <div class="row g-4">
                @foreach($recentlyViewed ?? [] as $item)
                <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                    <div class="card border-0 h-100">
                        <a href="{{ route('client.products.show', $item) }}">
                            <img src="{{ $item->image ? (Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=60' }}" 
                                 class="card-img-top rounded" 
                                 alt="{{ $item->name }}"
                                 style="height: 120px; object-fit: cover;">
                        </a>
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1">
                                <a href="{{ route('client.products.show', $item) }}" class="text-decoration-none text-dark small">
                                    {{ Str::limit($item->name, 30) }}
                                </a>
                            </h6>
                            <p class="card-text fw-bold text-primary mb-0 small">{{ number_format($item->price, 2) }} DT</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<!-- Styles additionnels -->
<style>
    .product-gallery .main-image-container {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: #f8f9fa;
    }
    
    .product-gallery .main-image-container img {
        width: 100%;
        height: 400px;
        object-fit: contain;
        padding: 20px;
        background: white;
    }
    
    .thumbnail-container .thumbnail {
        border: 2px solid transparent;
        transition: all 0.3s;
    }
    
    .thumbnail-container .thumbnail:hover,
    .thumbnail-container .thumbnail.active {
        border-color: var(--primary-color);
        transform: scale(1.05);
    }
    
    .product-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.85rem;
        z-index: 10;
    }
    
    .badge-success {
        background: var(--accent-color);
        color: white;
    }
    
    .badge-warning {
        background: var(--warning-color);
        color: white;
    }
    
    .product-rating {
        color: #f59e0b;
    }
    
    .nav-tabs .nav-link {
        color: #6b7280;
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 500;
    }
    
    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        border-bottom: 3px solid var(--primary-color);
        background: none;
    }
    
    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
    }
    
    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s;
        border: 1px solid #e5e7eb;
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
    }
    
    .product-body {
        padding: 1.25rem;
    }
    
    .product-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark-color);
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
    
    .breadcrumb {
        background: none;
        padding: 0;
    }
    
    .breadcrumb-item a:hover {
        text-decoration: underline !important;
    }
    
    .product-description {
        line-height: 1.8;
        font-size: 1.05rem;
    }
    
    .product-description img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
    
    /* Animation pour l'ajout au panier */
    @keyframes addToCart {
        0% { transform: scale(1); }
        50% { transform: scale(0.95); }
        100% { transform: scale(1); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des miniatures
        function changeMainImage(element) {
            const mainImage = document.getElementById('mainProductImage');
            mainImage.src = element.src;
            
            // Mettre à jour les miniatures actives
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            element.classList.add('active');
        }
        
        // Gestion de la quantité
        const quantityInput = document.getElementById('quantity');
        
        window.increaseQuantity = function() {
            const max = parseInt(quantityInput.max);
            const current = parseInt(quantityInput.value);
            if (current < max) {
                quantityInput.value = current + 1;
            }
        }
        
        window.decreaseQuantity = function() {
            const min = parseInt(quantityInput.min);
            const current = parseInt(quantityInput.value);
            if (current > min) {
                quantityInput.value = current - 1;
            }
        }
        
        // Validation de la quantité
        quantityInput.addEventListener('change', function() {
            const max = parseInt(this.max);
            const min = parseInt(this.min);
            let value = parseInt(this.value);
            
            if (isNaN(value) || value < min) {
                value = min;
            } else if (value > max) {
                value = max;
            }
            
            this.value = value;
        });
        
        // Ajout au panier avec animation
        const addToCartForm = document.getElementById('addToCartForm');
        const addToCartBtn = document.getElementById('addToCartBtn');
        
        if (addToCartForm && addToCartBtn) {
            addToCartForm.addEventListener('submit', function(e) {
                // Animation du bouton
                addToCartBtn.disabled = true;
                const originalHTML = addToCartBtn.innerHTML;
                addToCartBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Ajouté !';
                addToCartBtn.classList.add('btn-success');
                addToCartBtn.classList.remove('btn-primary');
                
                // Animation
                addToCartBtn.style.animation = 'addToCart 0.3s ease-in-out';
                
                // Mettre à jour le badge panier
                updateCartCount();
                
                // Réinitialiser après 2 secondes
                setTimeout(() => {
                    addToCartBtn.innerHTML = originalHTML;
                    addToCartBtn.classList.remove('btn-success');
                    addToCartBtn.classList.add('btn-primary');
                    addToCartBtn.style.animation = '';
                    addToCartBtn.disabled = false;
                }, 2000);
            });
        }
        
        // Bouton favoris
        const wishlistBtn = document.getElementById('wishlistBtn');
        if (wishlistBtn) {
            wishlistBtn.addEventListener('click', function() {
                const isActive = this.classList.contains('btn-danger');
                
                if (isActive) {
                    this.classList.remove('btn-danger');
                    this.classList.add('btn-outline-primary');
                    this.innerHTML = '<i class="bi bi-heart"></i><span class="d-none d-md-inline ms-1">Favoris</span>';
                    showToast('Retiré des favoris', 'info');
                } else {
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-danger');
                    this.innerHTML = '<i class="bi bi-heart-fill"></i><span class="d-none d-md-inline ms-1">Favori</span>';
                    showToast('Ajouté aux favoris', 'success');
                }
            });
        }
        
        // Mettre à jour le compteur du panier
        function updateCartCount() {
            const cartBadge = document.querySelector('.cart-badge');
            if (cartBadge) {
                let currentCount = parseInt(cartBadge.textContent) || 0;
                const quantity = parseInt(quantityInput?.value || 1);
                cartBadge.textContent = currentCount + quantity;
                cartBadge.style.animation = 'pulse 0.5s';
                
                setTimeout(() => {
                    cartBadge.style.animation = '';
                }, 500);
            }
        }
        
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
        
        // Zoom sur image (simplifié)
        const mainImage = document.getElementById('mainProductImage');
        if (mainImage) {
            mainImage.addEventListener('mouseenter', function() {
                this.style.cursor = 'zoom-in';
            });
            
            mainImage.addEventListener('click', function() {
                if (this.style.transform === 'scale(1.5)') {
                    this.style.transform = 'scale(1)';
                    this.style.cursor = 'zoom-in';
                } else {
                    this.style.transform = 'scale(1.5)';
                    this.style.cursor = 'zoom-out';
                }
            });
        }
        
        // Suivi du temps sur la page (pour analytics)
        let timeOnPage = 0;
        setInterval(() => {
            timeOnPage++;
            if (timeOnPage === 30) {
                console.log('Utilisateur a passé 30 secondes sur la page produit');
            }
        }, 1000);
    });
</script>
@endsection