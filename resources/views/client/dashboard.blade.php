@extends('client.layouts')

@section('title', 'Accueil')

@section('content')

<div class="container-fluid">
    <!-- En-tête du dashboard -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-2">Bienvenue, {{ Auth::user()->name ?? 'Client' }} 👋</h1>
                    <p class="text-muted mb-0">Découvrez nos meilleurs produits et promotions</p>
                </div>
                <div class="d-flex gap-3">
                    <div class="text-end">
                        <div class="text-muted small">Solde actuel</div>
                        <div class="h4 fw-bold text-success">245,50 DT</div>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small">Points fidélité</div>
                        <div class="h4 fw-bold text-warning">1,245 pts</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistiques rapides -->
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Commandes</h6>
                            <h2 class="fw-bold mb-0">12</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-box-seam text-primary fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="text-decoration-none text-primary">
                            Voir mes commandes <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Favoris</h6>
                            <h2 class="fw-bold mb-0">8</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-heart text-success fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="text-decoration-none text-success">
                            Voir mes favoris <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Panier</h6>
                            <h2 class="fw-bold mb-0">{{ count(session('cart', [])) }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-cart text-warning fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('cart.index') }}" class="text-decoration-none text-warning">
                            Voir mon panier <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-info border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Promotions</h6>
                            <h2 class="fw-bold mb-0">24</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-percent text-info fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('client.promotions') }}" class="text-decoration-none text-info">
                            Voir les promos <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Nouveautés et promotions -->
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bold">🔥 Nouveautés</h3>
                <a href="{{ route('client.products') }}" class="btn btn-outline-primary">
                    Voir tout <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        
        @foreach($newProducts ?? [] as $product)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="product-card">
                <div class="position-relative">
                    <span class="product-badge badge-new">Nouveau</span>
                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60' }}" 
                         class="product-image" 
                         alt="{{ $product->name }}">
                </div>
                <div class="product-body">
                    <h5 class="product-title">{{ $product->name }}</h5>
                    <div class="d-flex align-items-center mb-2">
                        <span class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ms-1 text-muted">(4.5)</span>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="product-price">{{ number_format($product->price, 2) }} DT</span>
                            @if($product->old_price)
                                <span class="product-old-price">{{ number_format($product->old_price, 2) }} DT</span>
                            @endif
                        </div>
                        <button class="btn btn-primary-client btn-sm">
                            <i class="bi bi-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Produits populaires -->
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bold">⭐ Produits populaires</h3>
                <a href="#" class="btn btn-outline-warning">
                    Découvrir <i class="bi bi-fire"></i>
                </a>
            </div>
        </div>
        
        @foreach($popularProducts ?? [] as $product)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="product-card">
                <div class="position-relative">
                    <span class="product-badge badge-hot">Tendance</span>
                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60' }}" 
                         class="product-image" 
                         alt="{{ $product->name }}">
                </div>
                <div class="product-body">
                    <h5 class="product-title">{{ $product->name }}</h5>
                    <div class="d-flex align-items-center mb-2">
                        <span class="product-rating">
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
                            <span class="product-price">{{ number_format($product->price, 2) }} DT</span>
                            @if($product->old_price)
                                <span class="product-old-price">{{ number_format($product->old_price, 2) }} DT</span>
                            @endif
                        </div>
                        <button class="btn btn-primary-client btn-sm">
                            <i class="bi bi-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Promotions -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bold">🎯 Promotions du moment</h3>
                <a href="{{ route('client.promotions') }}" class="btn btn-outline-danger">
                    Toutes les promos <i class="bi bi-percent"></i>
                </a>
            </div>
        </div>
        
        @foreach($promoProducts ?? [] as $product)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="product-card">
                <div class="position-relative">
                    <span class="product-badge badge-sale">-{{ rand(10, 50) }}%</span>
                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1503602642458-232111445657?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60' }}" 
                         class="product-image" 
                         alt="{{ $product->name }}">
                </div>
                <div class="product-body">
                    <h5 class="product-title">{{ $product->name }}</h5>
                    <div class="d-flex align-items-center mb-2">
                        <span class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <i class="bi bi-star"></i>
                            <span class="ms-1 text-muted">(3.0)</span>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="product-price">{{ number_format($product->price * 0.8, 2) }} DT</span>
                            <span class="product-old-price">{{ number_format($product->price, 2) }} DT</span>
                        </div>
                        <button class="btn btn-primary-client btn-sm">
                            <i class="bi bi-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Styles additionnels pour le dashboard -->
<style>
    /* Animation pour les cartes produits */
    .product-card {
        position: relative;
        overflow: hidden;
    }
    
    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
        transition: 0.5s;
    }
    
    .product-card:hover::before {
        left: 100%;
    }
    
    /* Animation pour les badges */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .badge-new, .badge-hot, .badge-sale {
        animation: float 3s ease-in-out infinite;
    }
    
    /* Animation pour les cartes statistiques */
    .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
    
    /* Gradient pour les titres */
    .gradient-text {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des cartes au chargement
        document.querySelectorAll('.product-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s, transform 0.5s';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Animation des statistiques
        const counters = document.querySelectorAll('.card .fw-bold.mb-0');
        counters.forEach(counter => {
            const target = parseInt(counter.textContent);
            if (!isNaN(target)) {
                animateCounter(counter, target);
            }
        });
        
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 20;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 50);
        }
        
        // Interaction avec les boutons "Ajouter au panier"
        document.querySelectorAll('.btn-primary-client.btn-sm').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const productCard = this.closest('.product-card');
                const productName = productCard.querySelector('.product-title').textContent;
                const productPrice = productCard.querySelector('.product-price').textContent;
                
                // Animation du bouton
                this.innerHTML = '<i class="bi bi-check-lg"></i>';
                this.classList.add('btn-success');
                this.classList.remove('btn-primary-client');
                
                // Animation du badge panier
                const cartBadge = document.querySelector('.cart-badge');
                if (cartBadge) {
                    let currentCount = parseInt(cartBadge.textContent) || 0;
                    cartBadge.textContent = currentCount + 1;
                    cartBadge.style.animation = 'pulse 0.5s';
                    
                    setTimeout(() => {
                        cartBadge.style.animation = '';
                    }, 500);
                } else {
                    // Créer le badge si il n'existe pas
                    const cartIcon = document.querySelector('.nav-icon-link[href*="cart"]');
                    if (cartIcon) {
                        const badge = document.createElement('span');
                        badge.className = 'cart-badge';
                        badge.textContent = '1';
                        cartIcon.appendChild(badge);
                    }
                }
                
                // Message toast (simulation)
                showToast('Produit ajouté au panier !');
                
                // Réinitialiser le bouton après 2 secondes
                setTimeout(() => {
                    this.innerHTML = '<i class="bi bi-cart-plus"></i>';
                    this.classList.remove('btn-success');
                    this.classList.add('btn-primary-client');
                }, 2000);
            });
        });
        
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 end-0 p-3';
            toast.style.zIndex = '1050';
            
            toast.innerHTML = `
                <div class="toast show" role="alert">
                    <div class="toast-header bg-success text-white">
                        <i class="bi bi-check-circle me-2"></i>
                        <strong class="me-auto">Succès</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    });
</script>
@endsection
