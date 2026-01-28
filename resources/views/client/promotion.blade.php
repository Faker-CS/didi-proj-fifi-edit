@extends('client.layouts')

@section('title', 'Promotions du moment - ShopStore')

@section('content')
<div class="container-fluid py-4">
    
    <!-- En-tête de la page promotions -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="mb-3 mb-md-0">
                    <h1 class="fw-bold mb-2">🔥 Promotions du moment</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-clock me-1"></i>
                        @if($promotions->count() > 0)
                            @php
                                $maxEndDate = $promotions->max('end_date');
                            @endphp
                            Offres spéciales valables jusqu'au {{ \Carbon\Carbon::parse($maxEndDate)->format('d/m/Y') }}
                        @else
                            Aucune promotion active pour le moment
                        @endif
                    </p>
                </div>
                
                <!-- Compteur promotions -->
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end">
                        <div class="text-muted small">Promotions actives</div>
                        <div class="h3 fw-bold text-danger">{{ $promotions->count() }}</div>
                    </div>
                    <div class="vr d-none d-md-block"></div>
                    <div class="text-end d-none d-md-block">
                        <div class="text-muted small">Jours restants</div>
                        @if($promotions->count() > 0)
                            @php
                                $maxEndDate = $promotions->max('end_date');
                                $daysLeft = \Carbon\Carbon::parse($maxEndDate)->diffInDays(now());
                            @endphp
                            <div class="h3 fw-bold text-warning" id="daysRemaining">{{ max(0, $daysLeft) }}</div>
                        @else
                            <div class="h3 fw-bold text-warning" id="daysRemaining">0</div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Barre de progression du temps -->
            @if($promotions->count() > 0)
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">Fin des promotions</small>
                    <small class="text-danger fw-semibold" id="timeRemaining"></small>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" 
                         id="promotionProgress" 
                         style="width: 65%"></div>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Promotions en vedette -->
    @if(isset($featuredPromotions) && $featuredPromotions->count() > 0)
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="fw-bold mb-4">⭐ Promotions phares</h2>
            
            <div class="row g-4">
                @foreach($featuredPromotions as $promotion)
                    @php
                        $product = $promotion->product;
                        // Utilisation de la méthode discounted_price du modèle Product
                        $discountedPrice = $product->discounted_price ?? $product->price * (1 - $promotion->discount_percent / 100);
                        $daysLeft = \Carbon\Carbon::parse($promotion->end_date)->diffInDays(now());
                        $daysLeft = max(0, $daysLeft); // Éviter les valeurs négatives
                    @endphp
                    
                    <div class="col-xl-4 col-md-6">
                        <div class="card promotion-card border-0 shadow-lg overflow-hidden">
                            <!-- Badge promotion -->
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-danger fs-6 px-3 py-2">
                                    -{{ $promotion->discount_percent }}%
                                </span>
                            </div>
                            
                            <!-- Compteur limité -->
                            @if($daysLeft > 0)
                            <div class="position-absolute top-0 end-0 m-3">
                                <div class="text-center">
                                    <div class="text-white bg-dark bg-opacity-75 rounded-circle p-2" style="width: 50px; height: 50px;">
                                        <div class="fs-5 fw-bold">{{ $daysLeft }}</div>
                                        <small class="d-block">jours</small>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Image produit -->
                            <div class="promotion-image-container">
                                <img src="{{ $product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://via.placeholder.com/800x400' }}" 
                                     alt="{{ $product->name }}" 
                                     class="promotion-main-image">
                                <div class="promotion-overlay">
                                    <div class="promotion-overlay-content">
                                        <h5 class="text-white mb-3">Économisez {{ number_format($product->price - $discountedPrice, 2) }} DT</h5>
                                        <a href="{{ route('client.products.show', $product) }}" class="btn btn-light btn-lg">
                                            <i class="bi bi-arrow-right me-2"></i>Voir l'offre
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Contenu promotion -->
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    @if($product->category)
                                    <span class="badge bg-light text-dark mb-2">
                                        <i class="bi bi-tag me-1"></i>{{ $product->category->name }}
                                    </span>
                                    @endif
                                    @if($promotion->discount_percent >= 30)
                                    <span class="badge bg-warning text-dark ms-2">
                                        <i class="bi bi-lightning me-1"></i>Vente flash
                                    </span>
                                    @endif
                                </div>
                                
                                <h3 class="card-title fw-bold mb-2">
                                    <a href="{{ route('client.products.show', $product) }}" class="text-decoration-none text-dark">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                
                                <!-- Prix -->
                                <div class="d-flex align-items-baseline mb-3">
                                    <span class="text-muted text-decoration-line-through me-3 fs-5">
                                        {{ number_format($product->price, 2) }} DT
                                    </span>
                                    <span class="fs-3 fw-bold text-danger">
                                        {{ number_format($discountedPrice, 2) }} DT
                                    </span>
                                </div>
                                
                                <!-- Barre de progression des ventes -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Quantité limitée</small>
                                        @if($product->stock > 0)
                                        <small class="text-danger fw-semibold">Il en reste {{ min($product->stock, 20) }}</small>
                                        @else
                                        <small class="text-danger fw-semibold">Rupture de stock</small>
                                        @endif
                                    </div>
                                    @if($product->stock > 0)
                                    <div class="progress" style="height: 6px;">
                                        @php
                                            $stockPercentage = min(100, ($product->stock / 100) * 100);
                                        @endphp
                                        <div class="progress-bar bg-danger" style="width: {{ $stockPercentage }}%"></div>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Actions -->
                                <div class="d-flex gap-2">
                                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex-grow-1">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-danger btn-lg w-100" 
                                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                            <i class="bi bi-cart-plus me-2"></i>
                                            {{ $product->stock > 0 ? 'Ajouter au panier' : 'Rupture de stock' }}
                                        </button>
                                    </form>
                                    <button class="btn btn-outline-danger btn-lg" onclick="toggleWishlist({{ $product->id }})">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    
    <!-- Toutes les promotions -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">🎯 Toutes les promotions</h2>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-filter me-2"></i>Trier par
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?sort=discount_desc">Réduction décroissante</a></li>
                        <li><a class="dropdown-item" href="?sort=price_asc">Prix croissant</a></li>
                        <li><a class="dropdown-item" href="?sort=price_desc">Prix décroissant</a></li>
                        <li><a class="dropdown-item" href="?sort=end_date">Fin proche</a></li>
                    </ul>
                </div>
            </div>
            
            @if($promotions->count() > 0)
            <div class="row g-4">
                @foreach($promotions as $promotion)
                    @php
                        $product = $promotion->product;
                        if (!$product) continue; // Skip if product doesn't exist
                        
                        // Utilisation de la méthode discounted_price du modèle Product
                        $discountedPrice = $product->discounted_price ?? $product->price * (1 - $promotion->discount_percent / 100);
                        $daysLeft = \Carbon\Carbon::parse($promotion->end_date)->diffInDays(now());
                        $daysLeft = max(0, $daysLeft); // Éviter les valeurs négatives
                        $isLastChance = $daysLeft <= 3;
                        $isHotDeal = $promotion->discount_percent >= 30;
                    @endphp
                    
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card promotion-item-card h-100 border-0 shadow-sm">
                            <!-- En-tête avec badge -->
                            <div class="card-header bg-white border-0 position-relative">
                                <div class="promotion-header-badges">
                                    @if($isLastChance && $daysLeft > 0)
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-clock me-1"></i>Dernière chance
                                        </span>
                                    @endif
                                    @if($isHotDeal)
                                        <span class="badge bg-danger">
                                            <i class="bi bi-fire me-1"></i>Super promo
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Image produit -->
                                <div class="promotion-item-image-container">
                                    <img src="{{ $product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://via.placeholder.com/500x300' }}" 
                                         alt="{{ $product->name }}" 
                                         class="promotion-item-image">
                                    <div class="promotion-discount-badge">
                                        -{{ $promotion->discount_percent }}%
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Corps de la carte -->
                            <div class="card-body d-flex flex-column">
                                <!-- Catégorie -->
                                @if($product->category)
                                <div class="mb-2">
                                    <span class="badge bg-light text-dark">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                                @endif
                                
                                <!-- Nom produit -->
                                <h5 class="card-title fw-semibold mb-2">
                                    <a href="{{ route('client.products.show', $product) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($product->name, 50) }}
                                    </a>
                                </h5>
                                
                                <!-- Notation (optionnelle, vous pouvez l'enlever si pas de système de notation) -->
                                @if(isset($product->rating) && $product->rating > 0)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="product-rating small me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star-fill {{ $i <= $product->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">({{ $product->reviews_count ?? 0 }})</small>
                                </div>
                                @endif
                                
                                <!-- Prix -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-baseline">
                                        <span class="text-muted text-decoration-line-through me-2">
                                            {{ number_format($product->price, 2) }} DT
                                        </span>
                                        <span class="fs-4 fw-bold text-danger">
                                            {{ number_format($discountedPrice, 2) }} DT
                                        </span>
                                    </div>
                                    <small class="text-success">
                                        <i class="bi bi-arrow-down me-1"></i>
                                        Économisez {{ number_format($product->price - $discountedPrice, 2) }} DT
                                    </small>
                                </div>
                                
                                <!-- Timer -->
                                @if($daysLeft > 0)
                                <div class="mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock text-danger me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Fin dans</small>
                                            <div class="fw-semibold text-danger" data-countdown="{{ $promotion->end_date }}">
                                                {{ $daysLeft }} jour{{ $daysLeft > 1 ? 's' : '' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="mb-4">
                                    <div class="alert alert-warning py-2">
                                        <small><i class="bi bi-exclamation-triangle me-1"></i>Promotion expirée</small>
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Actions -->
                                <div class="d-flex gap-2 mt-auto">
                                    <a href="{{ route('client.products.show', $product) }}" 
                                       class="btn btn-outline-primary btn-sm flex-grow-1">
                                        <i class="bi bi-eye me-1"></i>Voir
                                    </a>
                                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                {{ $product->stock <= 0 ? 'disabled' : '' }}
                                                title="{{ $product->stock > 0 ? 'Ajouter au panier' : 'Rupture de stock' }}">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Footer avec date -->
                            <div class="card-footer bg-white border-top text-center">
                                <small class="text-muted">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    Valable du {{ \Carbon\Carbon::parse($promotion->start_date)->format('d/m') }} 
                                    au {{ \Carbon\Carbon::parse($promotion->end_date)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($promotions->hasPages())
            <div class="mt-5">
                <nav aria-label="Navigation des promotions">
                    {{ $promotions->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                </nav>
            </div>
            @endif
            
            @else
            <!-- Aucune promotion -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-percent display-1 text-muted mb-4"></i>
                    <h3 class="fw-bold mb-3">Aucune promotion active</h3>
                    <p class="text-muted mb-4">
                        Il n'y a pas de promotion active pour le moment. Revenez plus tard pour découvrir nos offres spéciales !
                    </p>
                    <a href="{{ route('client.dashboard') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Retour aux produits
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    
    <!-- Conditions des promotions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Conditions des promotions</h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-calendar-check text-primary me-2 mt-1"></i>
                                <div>
                                    <small class="text-muted d-block">Dates</small>
                                    <small>Valables pendant la période indiquée</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-cart-check text-primary me-2 mt-1"></i>
                                <div>
                                    <small class="text-muted d-block">Quantités</small>
                                    <small>Dans la limite des stocks disponibles</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-arrow-left-right text-primary me-2 mt-1"></i>
                                <div>
                                    <small class="text-muted d-block">Retours</small>
                                    <small>Mêmes conditions que les produits standards</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-percent text-primary me-2 mt-1"></i>
                                <div>
                                    <small class="text-muted d-block">Cumul</small>
                                    <small>Non cumulable avec autres promotions</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- Styles additionnels pour la page promotions -->
<style>
    .promotion-card {
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .promotion-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
    }
    
    .promotion-image-container {
        position: relative;
        height: 250px;
        overflow: hidden;
    }
    
    .promotion-main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .promotion-card:hover .promotion-main-image {
        transform: scale(1.1);
    }
    
    .promotion-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 2rem;
    }
    
    .promotion-card:hover .promotion-overlay {
        opacity: 1;
    }
    
    .promotion-overlay-content {
        transform: translateY(20px);
        transition: transform 0.3s ease;
    }
    
    .promotion-card:hover .promotion-overlay-content {
        transform: translateY(0);
    }
    
    .promotion-item-card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .promotion-item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }
    
    .promotion-header-badges {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 10;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .promotion-item-image-container {
        position: relative;
        height: 180px;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .promotion-item-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .promotion-discount-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .progress-bar-animated {
        animation: progress-animation 2s ease-in-out infinite;
    }
    
    @keyframes progress-animation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .bg-gradient {
        background-size: 200% 200%;
        animation: gradient-animation 15s ease infinite;
    }
    
    @keyframes gradient-animation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Animation pour les badges */
    @keyframes pulse-badge {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    .badge-danger, .badge-warning {
        animation: pulse-badge 2s ease-in-out infinite;
    }
    
    /* Compteur pour dernières chances */
    .countdown-timer {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
    
    .countdown-item {
        background: #ef4444;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        min-width: 40px;
        text-align: center;
    }
    
    .countdown-label {
        font-size: 0.7rem;
        opacity: 0.8;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Compteur de jours restants
        @if($promotions->count() > 0)
        function updateCountdown() {
            const endDate = new Date('{{ $promotions->max("end_date") }}');
            const now = new Date();
            const diffTime = endDate - now;
            
            if (diffTime <= 0) {
                document.getElementById('daysRemaining').textContent = '0';
                document.getElementById('timeRemaining').textContent = 'Expiré';
                document.getElementById('promotionProgress').style.width = '100%';
                return;
            }
            
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            document.getElementById('daysRemaining').textContent = diffDays;
            
            // Mettre à jour la barre de progression
            const startDate = new Date('{{ $promotions->min("start_date") }}');
            const totalDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
            const elapsedDays = Math.ceil((now - startDate) / (1000 * 60 * 60 * 24));
            const progress = Math.min(100, (elapsedDays / totalDays) * 100);
            document.getElementById('promotionProgress').style.width = progress + '%';
            
            // Mettre à jour le texte restant
            const hours = Math.floor((diffTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diffTime % (1000 * 60 * 60)) / (1000 * 60));
            document.getElementById('timeRemaining').textContent = 
                diffDays + 'j ' + hours + 'h ' + minutes + 'm';
        }
        
        // Initialiser et mettre à jour toutes les 60 secondes
        updateCountdown();
        setInterval(updateCountdown, 60000);
        @endif
        
        // Compteurs pour chaque promotion
        document.querySelectorAll('[data-countdown]').forEach(element => {
            const endDate = new Date(element.getAttribute('data-countdown'));
            
            function updatePromotionCountdown() {
                const now = new Date();
                const diffTime = endDate - now;
                
                if (diffTime <= 0) {
                    element.innerHTML = '<span class="text-danger">Expiré</span>';
                    // Désactiver le bouton d'ajout au panier
                    const card = element.closest('.promotion-item-card');
                    if (card) {
                        const addButton = card.querySelector('form button[type="submit"]');
                        if (addButton) {
                            addButton.disabled = true;
                            addButton.classList.remove('btn-danger');
                            addButton.classList.add('btn-secondary');
                        }
                    }
                    return;
                }
                
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const diffHours = Math.floor((diffTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                
                if (diffDays === 0) {
                    element.innerHTML = `
                        <div class="countdown-timer">
                            <div class="countdown-item">
                                <div class="fw-bold">${diffHours}</div>
                                <div class="countdown-label">heures</div>
                            </div>
                        </div>`;
                } else {
                    element.textContent = diffDays + ' jour' + (diffDays > 1 ? 's' : '');
                }
                
                // Ajouter une classe si dernière chance
                if (diffDays <= 1) {
                    element.classList.add('text-danger', 'fw-bold');
                    const clockIcon = element.parentElement.parentElement.querySelector('.bi-clock');
                    if (clockIcon) {
                        clockIcon.classList.add('text-danger');
                    }
                }
            }
            
            updatePromotionCountdown();
            setInterval(updatePromotionCountdown, 60000);
        });
        
        // Animation des cartes au survol
        document.querySelectorAll('.promotion-card, .promotion-item-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = this.classList.contains('promotion-card') ? 
                    'translateY(-10px)' : 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Gestion de l'inscription à la newsletter
        const newsletterForm = document.querySelector('.promotion-newsletter-form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                const emailInput = this.querySelector('input[type="email"]');
                const consentCheckbox = this.querySelector('#promotionConsent');
                const submitButton = this.querySelector('button[type="submit"]');
                
                if (!emailInput.value) {
                    e.preventDefault();
                    showToast('Veuillez entrer votre email', 'warning');
                    return;
                }
                
                if (!consentCheckbox.checked) {
                    e.preventDefault();
                    showToast('Veuillez accepter de recevoir les offres', 'warning');
                    return;
                }
                
                // Changer l'apparence du bouton pendant l'envoi
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Envoi en cours...';
            });
        }
        
        // Gestion des wishlists
        window.toggleWishlist = function(productId) {
            const buttons = document.querySelectorAll(`button[onclick="toggleWishlist(${productId})"]`);
            
            buttons.forEach(button => {
                const isActive = button.classList.contains('btn-danger');
                
                if (isActive) {
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-outline-danger');
                    button.innerHTML = '<i class="bi bi-heart"></i>';
                    showToast('Retiré des favoris', 'info');
                } else {
                    button.classList.remove('btn-outline-danger');
                    button.classList.add('btn-danger');
                    button.innerHTML = '<i class="bi bi-heart-fill"></i>';
                    showToast('Ajouté aux favoris', 'success');
                }
            });
        };
        
        // Animation au chargement des cartes
        document.querySelectorAll('.promotion-card, .promotion-item-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s, transform 0.5s';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
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
    });
</script>
@endsection