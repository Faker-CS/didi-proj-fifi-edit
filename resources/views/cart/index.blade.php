@extends('client.layouts')

@section('title', 'Mon Panier')

@section('content')
<div class="container-fluid">
    <!-- En-tête du panier -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-2">🛒 Mon Panier</h1>
                    <p class="text-muted mb-0">
                        @if(count($cartItems ?? []) > 0)
                            {{ count($cartItems ?? []) }} article(s) dans votre panier
                        @else
                            Votre panier est vide
                        @endif
                    </p>
                </div>
                <div>
                    <a href="{{ route('client.dashboard') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Continuer mes achats
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(count($cartItems ?? []) > 0)
    <div class="row">
        <!-- Liste des produits -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold">Articles dans votre panier</h5>
                    @if($totalSavings > 0)
                    <div class="badge bg-success mt-1">
                        <i class="bi bi-tag me-1"></i>Vous économisez {{ number_format($totalSavings, 2) }} DT
                    </div>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;"></th>
                                    <th>Produit</th>
                                    <th class="text-center">Prix unitaire</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $id => $item)
                                    <tr>
                                        <td>
                                            <img src="{{ $item['image'] ?? 'https://via.placeholder.com/60' }}" 
                                                 alt="{{ $item['name'] }}" 
                                                 class="rounded" 
                                                 width="60" 
                                                 height="60"
                                                 style="object-fit: cover;">
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong class="mb-1">{{ $item['name'] }}</strong>
                                                @if($item['has_promotion'] ?? false)
                                                    <span class="badge bg-danger mb-1" style="width: fit-content;">
                                                        🔥 -{{ $item['discount_percent'] ?? 0 }}%
                                                    </span>
                                                @endif
                                                <small class="text-muted">Référence: {{ $item['sku'] ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                @if($item['has_promotion'] ?? false)
                                                    <del class="text-muted small">
                                                        {{ number_format($item['original_price'], 2) }} DT
                                                    </del>
                                                    <span class="fw-bold text-success">
                                                        {{ number_format($item['price'], 2) }} DT
                                                    </span>
                                                @else
                                                    <span class="fw-semibold">{{ number_format($item['price'], 2) }} DT</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <form method="POST" action="{{ route('cart.decrease', $id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                </form>
                                                
                                                <span class="mx-3 fw-semibold">{{ $item['quantity'] }}</span>
                                                
                                                <form method="POST" action="{{ route('cart.increase', $id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                @if($item['has_promotion'] ?? false)
                                                    <del class="text-muted small">
                                                        {{ number_format($item['original_price'] * $item['quantity'], 2) }} DT
                                                    </del>
                                                    <span class="fw-bold text-primary">
                                                        {{ number_format($item['price'] * $item['quantity'], 2) }} DT
                                                    </span>
                                                    <small class="text-success">
                                                        Économisé: {{ number_format(($item['original_price'] - $item['price']) * $item['quantity'], 2) }} DT
                                                    </small>
                                                @else
                                                    <span class="fw-bold">{{ number_format($item['price'] * $item['quantity'], 2) }} DT</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('cart.remove', $id) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit du panier ?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between">
                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?')">
                                <i class="bi bi-trash me-2"></i>Vider le panier
                            </button>
                        </form>
                        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-primary">
                            <i class="bi bi-plus-circle me-2"></i>Ajouter d'autres produits
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Livraison et codes promo -->
            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0 fw-semibold">🛵 Options de livraison</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="delivery" id="standard" checked>
                                <label class="form-check-label" for="standard">
                                    <span class="fw-medium">Livraison standard</span>
                                    <small class="text-muted d-block">3-5 jours ouvrables - 4,99 DT</small>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="delivery" id="express">
                                <label class="form-check-label" for="express">
                                    <span class="fw-medium">Livraison express</span>
                                    <small class="text-muted d-block">1-2 jours ouvrables - 9,99 DT</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery" id="pickup">
                                <label class="form-check-label" for="pickup">
                                    <span class="fw-medium">Retrait en magasin</span>
                                    <small class="text-muted d-block">Gratuit - Prêt dans 2h</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0 fw-semibold">🎟️ Code promo</h6>
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Entrez votre code promo" id="promoCode">
                                <button class="btn btn-primary" type="button" id="applyPromo">Appliquer</button>
                            </div>
                            <div class="alert alert-info d-none" id="promoMessage">
                                <i class="bi bi-info-circle me-2"></i>
                                <span id="promoText"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Récapitulatif de commande -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm sticky-top" style="top: 100px;">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-semibold">📋 Récapitulatif</h5>
                </div>
                <div class="card-body">
                    <!-- Détails du prix -->
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Sous-total</span>
                        <span class="fw-medium">{{ number_format($item['original_price'], 2) }} DT</span>
                    </div>
                    
                    @if($totalSavings > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">
                            <i class="bi bi-tag text-success me-1"></i>Économies promotions
                        </span>
                        <span class="fw-medium text-success">-{{ number_format($totalSavings, 2) }} DT</span>
                    </div>
                    @endif
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Livraison</span>
                        <span class="fw-medium" id="shippingCost">4,9   9 DT</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3" id="discountContainer" style="display: none;">
                        <span class="text-muted">Réduction code promo</span>
                        <span class="fw-medium text-success" id="discountAmount">-0,00 DT</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold fs-4 text-primary" id="totalAmount">
                            {{ number_format($item['original_price'] + 4.99 - $totalSavings, 2) }} DT
                        </span>
                    </div>
                    
                    <!-- Boutons d'action -->
                    <div class="d-grid gap-3">
                        @auth
                            <a href="{{ route('client.checkout') }}" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-lock-fill me-2"></i>Finaliser la commande
                            </a>
                        @else
                            <!-- Bouton déclencheur modal -->
                            <button type="button" class="btn btn-success btn-lg w-100" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#loginModal"
                                    id="checkoutButton">
                                <i class="bi bi-lock-fill me-2"></i>Finaliser la commande
                            </button>
                            
                            <div class="text-center mt-2">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Vous devez vous connecter pour finaliser votre commande
                                </small>
                            </div>
                        @endauth
                        
                        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-cart-plus me-2"></i>Continuer mes achats
                        </a>
                    </div>
                    
                    <!-- Sécurité et garanties -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center mb-2">
                            <div class="security-icon">
                                <i class="bi bi-shield-check text-success"></i>
                            </div>
                            <div class="ms-3">
                                <small class="fw-medium">Paiement 100% sécurisé</small>
                                <small class="d-block text-muted">Vos données sont protégées</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="security-icon">
                                <i class="bi bi-arrow-counterclockwise text-primary"></i>
                            </div>
                            <div class="ms-3">
                                <small class="fw-medium">Retours gratuits</small>
                                <small class="d-block text-muted">Sous 30 jours</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="security-icon">
                                <i class="bi bi-headset text-warning"></i>
                            </div>
                            <div class="ms-3">
                                <small class="fw-medium">Support client</small>
                                <small class="d-block text-muted">7j/7 de 9h à 20h</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Produits recommandés -->
    @if(isset($recommendedProducts) && count($recommendedProducts) > 0)
    <div class="row mt-5">
        <div class="col-12 mb-4">
            <h4 class="fw-bold">✨ Produits en promotion</h4>
        </div>
        
        @foreach($recommendedProducts as $product)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="product-card position-relative">
                @if($product->hasActivePromotion())
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-danger py-2 px-3">
                            -{{ $product->discount_percent }}%
                        </span>
                    </div>
                @endif
                
                <img src="{{ $product->image ?? 'https://via.placeholder.com/300x200' }}" 
                     class="product-image" 
                     alt="{{ $product->name }}">
                
                <div class="product-body">
                    <h5 class="product-title">{{ $product->name }}</h5>
                    <div class="d-flex align-items-center mb-2">
                        @if($product->hasActivePromotion())
                            <del class="product-old-price me-2">
                                {{ number_format($product->price, 2) }} DT
                            </del>
                            <span class="product-price text-danger">
                                {{ number_format($product->discounted_price, 2) }} DT
                            </span>
                        @else
                            <span class="product-price">
                                {{ number_format($product->price, 2) }} DT
                            </span>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="add-to-cart-form">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 add-to-cart">
                            <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    @else
    <!-- Panier vide -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-cart-x display-1 text-muted mb-4"></i>
                    <h3 class="fw-bold mb-3">Votre panier est vide</h3>
                    <p class="text-muted mb-4">
                        Explorez nos produits et ajoutez vos articles préférés à votre panier.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('client.dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-shop me-2"></i>Découvrir nos produits
                        </a>
                        <a href="{{ route('client.promotions') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-percent me-2"></i>Voir les promotions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal de connexion/inscription -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <!-- En-tête -->
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title" id="loginModalLabel">
                    <i class="bi bi-person-circle me-2"></i>Finaliser votre commande
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-0">
                <!-- Navigation entre login et register -->
                <ul class="nav nav-tabs nav-justified border-0" id="authTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Connexion
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">
                            <i class="bi bi-person-plus me-2"></i>Inscription
                        </button>
                    </li>
                </ul>
                
                <!-- Contenu des onglets -->
                <div class="tab-content p-4">
                    <!-- Onglet Connexion -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        <div class="text-center mb-4">
                            <h5 class="fw-bold">Connectez-vous à votre compte</h5>
                            <p class="text-muted">Accédez à votre panier et finalisez votre commande</p>
                        </div>
                        
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf
                            
                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-medium">Adresse email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" 
                                           placeholder="votre@email.com" required
                                           value="{{ old('email') }}">
                                </div>
                            </div>
                            
                            <!-- Mot de passe -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label fw-medium">Mot de passe</label>
                                    <a href="#" class="text-decoration-none small">Mot de passe oublié ?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" 
                                           placeholder="Votre mot de passe" required
                                           id="loginPassword">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleLoginPassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Se souvenir de moi -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Se souvenir de moi
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Bouton de connexion -->
                            <button type="submit" class="btn btn-primary w-100 py-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                            </button>
                            
                            <!-- Divider -->
                            <div class="position-relative my-4">
                                <hr>
                                <div class="position-absolute top-50 start-50 translate-middle bg-white px-3">
                                    <small class="text-muted">OU</small>
                                </div>
                            </div>
                            
                            <!-- Connexion rapide avec compte client -->
                            <div class="text-center">
                                <p class="text-muted mb-2">Vous avez déjà commandé ?</p>
                                <button type="button" class="btn btn-outline-primary" id="quickLogin">
                                    <i class="bi bi-lightning me-2"></i>Connexion rapide
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Onglet Inscription -->
                    <div class="tab-pane fade" id="register" role="tabpanel">
                        <div class="text-center mb-4">
                            <h5 class="fw-bold">Créez votre compte</h5>
                            <p class="text-muted">Profitez d'une expérience personnalisée</p>
                        </div>
                        
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf
                            
                            <!-- Nom complet -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Prénom</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text" name="first_name" class="form-control" 
                                               placeholder="Votre prénom" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Nom</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text" name="last_name" class="form-control" 
                                               placeholder="Votre nom" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-medium">Adresse email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" 
                                           placeholder="votre@email.com" required>
                                </div>
                            </div>
                            
                            <!-- Téléphone -->
                            <div class="mb-3">
                                <label class="form-label fw-medium">Téléphone</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-phone"></i>
                                    </span>
                                    <input type="tel" name="phone" class="form-control" 
                                           placeholder="+216 XX XXX XXX">
                                </div>
                            </div>
                            
                            <!-- Mot de passe -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-medium">Mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control" 
                                               placeholder="Votre mot de passe" required
                                               id="registerPassword">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleRegisterPassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Confirmation</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock-fill"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" class="form-control" 
                                               placeholder="Confirmez le mot de passe" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Newsletter -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="newsletter" id="newsletter" checked>
                                    <label class="form-check-label" for="newsletter">
                                        Je souhaite recevoir les offres promotionnelles et nouveautés
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Bouton d'inscription -->
                            <button type="submit" class="btn btn-success w-100 py-3">
                                <i class="bi bi-person-plus me-2"></i>Créer mon compte
                            </button>
                            
                            <!-- Avantages de l'inscription -->
                            <div class="mt-4 pt-3 border-top">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <i class="bi bi-truck text-primary fs-4 d-block mb-2"></i>
                                        <small class="text-muted">Suivi commande</small>
                                    </div>
                                    <div class="col-4">
                                        <i class="bi bi-percent text-success fs-4 d-block mb-2"></i>
                                        <small class="text-muted">Promos exclusives</small>
                                    </div>
                                    <div class="col-4">
                                        <i class="bi bi-heart text-danger fs-4 d-block mb-2"></i>
                                        <small class="text-muted">Liste de souhaits</small>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Footer modal avec option de commande rapide -->
            <div class="modal-footer border-0 bg-light">
                <div class="w-100 text-center">
                    <p class="mb-2">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Votre panier est sauvegardé pendant 30 jours
                        </small>
                    </p>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left me-2"></i>Continuer mes achats
                    </button>
                </div>
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
        height: 100%;
        border: 1px solid #e5e7eb;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-color: #4361ee;
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
        color: #1e293b;
    }
    
    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: #4361ee;
    }
    
    .product-old-price {
        font-size: 0.9rem;
        color: #9ca3af;
        text-decoration: line-through;
        margin-right: 0.5rem;
    }
    
    .badge-promo {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        color: white;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.3rem 0.7rem;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(255, 107, 107, 0.3);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(99, 102, 241, 0.05);
    }
    
    .sticky-top {
        position: -webkit-sticky;
        position: sticky;
        z-index: 10;
    }
    
    /* Modal styles */
    #loginModal .modal-content {
        border-radius: 20px;
        overflow: hidden;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
    }
    
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 1rem;
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
    }
    
    .nav-tabs .nav-link.active {
        color: #4361ee;
        background-color: transparent;
        border-bottom: 3px solid #4361ee;
    }
    
    .security-icon {
        width: 40px;
        height: 40px;
        background-color: rgba(67, 97, 238, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    /* Animation de pulsation */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des options de livraison
    const deliveryOptions = document.querySelectorAll('input[name="delivery"]');
    const shippingCostElement = document.getElementById('shippingCost');
    const totalAmountElement = document.getElementById('totalAmount');
    const subtotal = {{ $subtotal ?? 0 }};
    const totalSavings = {{ $totalSavings ?? 0 }};
    
    deliveryOptions.forEach(option => {
        option.addEventListener('change', function() {
            let shippingCost = 0;
            let shippingText = '';
            
            switch(this.id) {
                case 'standard':
                    shippingCost = 4.99;
                    shippingText = '4,99 DT';
                    break;
                case 'express':
                    shippingCost = 9.99;
                    shippingText = '9,99 DT';
                    break;
                case 'pickup':
                    shippingCost = 0;
                    shippingText = 'Gratuit';
                    break;
            }
            
            shippingCostElement.textContent = shippingText;
            
            // Mettre à jour le total
            const discountElement = document.getElementById('discountAmount');
            let promoDiscount = 0;
            
            if (discountElement && discountElement.textContent.includes('-')) {
                promoDiscount = parseFloat(discountElement.textContent.replace('-', '').replace(',', '.').replace(' DT', ''));
            }
            
            const newTotal = subtotal + shippingCost - totalSavings - promoDiscount;
            totalAmountElement.textContent = newTotal.toFixed(2).replace('.', ',') + ' DT';
        });
    });
    
    // Gestion du code promo
    const promoInput = document.getElementById('promoCode');
    const promoButton = document.getElementById('applyPromo');
    const promoMessage = document.getElementById('promoMessage');
    const promoText = document.getElementById('promoText');
    const discountContainer = document.getElementById('discountContainer');
    const discountAmount = document.getElementById('discountAmount');
    
    if (promoButton) {
        promoButton.addEventListener('click', function() {
            const code = promoInput.value.trim().toUpperCase();
            
            if (!code) {
                showToast('Veuillez entrer un code promo', 'warning');
                return;
            }
            
            // Simuler une validation de code promo
            const validCodes = {
                'SOLDES20': 20,
                'WELCOME10': 10,
                'FLASH15': 15
            };
            
            if (validCodes[code]) {
                const discountPercentage = validCodes[code];
                const discountValue = (subtotal * discountPercentage) / 100;
                
                // Afficher la réduction
                discountContainer.style.display = 'flex';
                discountAmount.textContent = '-' + discountValue.toFixed(2).replace('.', ',') + ' DT';
                
                // Mettre à jour le message
                promoMessage.classList.remove('d-none');
                promoMessage.classList.remove('alert-danger');
                promoMessage.classList.add('alert-success');
                promoText.textContent = `Code "${code}" appliqué : ${discountPercentage}% de réduction !`;
                
                // Mettre à jour le total
                updateTotalWithDiscount(discountValue);
                
                showToast(`Réduction de ${discountPercentage}% appliquée !`, 'success');
            } else {
                promoMessage.classList.remove('d-none');
                promoMessage.classList.remove('alert-success');
                promoMessage.classList.add('alert-danger');
                promoText.textContent = 'Code promo invalide ou expiré';
                
                showToast('Code promo invalide', 'error');
            }
        });
    }
    
    // Fonction pour mettre à jour le total avec réduction
    function updateTotalWithDiscount(discount) {
        const shippingText = shippingCostElement.textContent;
        let shippingCost = 0;
        
        if (shippingText === 'Gratuit') {
            shippingCost = 0;
        } else {
            shippingCost = parseFloat(shippingText.replace(',', '.').replace(' DT', ''));
        }
        
        const newTotal = subtotal + shippingCost - totalSavings - discount;
        totalAmountElement.textContent = newTotal.toFixed(2).replace('.', ',') + ' DT';
    }
    
    // Animation pour les boutons d'ajout au panier
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            // Animation du bouton
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check-lg"></i> Ajouté';
            this.className = 'btn btn-success w-100';
            this.disabled = true;
            
            // Soumettre le formulaire
            setTimeout(() => {
                form.submit();
            }, 500);
            
            showToast('Produit ajouté au panier !', 'success');
        });
    });
    
    // Gestion de la modal de login
    const loginModal = document.getElementById('loginModal');
    const checkoutButton = document.getElementById('checkoutButton');
    
    // Si l'utilisateur n'est pas connecté, configurer le bouton de checkout
    if (checkoutButton && !{{ Auth::check() ? 'true' : 'false' }}) {
        checkoutButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Animation du bouton
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-lock me-2"></i>Ouverture...';
            this.disabled = true;
            
            // Ouvrir la modal après un léger délai
            setTimeout(() => {
                const modal = new bootstrap.Modal(loginModal);
                modal.show();
                
                // Réinitialiser le bouton
                this.innerHTML = originalText;
                this.disabled = false;
            }, 300);
        });
        
        checkoutButton.classList.add('pulse-animation');
    }
    
    // Basculer la visibilité des mots de passe
    document.querySelectorAll('#toggleLoginPassword, #toggleRegisterPassword').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.id === 'toggleLoginPassword' ? 'loginPassword' : 'registerPassword';
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
    
    // Connexion rapide (simulée)
    const quickLoginBtn = document.getElementById('quickLogin');
    if (quickLoginBtn) {
        quickLoginBtn.addEventListener('click', function() {
            // Pré-remplir avec un compte test
            document.querySelector('input[name="email"]').value = 'client@example.com';
            document.querySelector('input[name="password"]').value = 'password';
            
            // Animation
            this.innerHTML = '<i class="bi bi-lightning-fill me-2"></i>Connexion...';
            this.disabled = true;
            
            // Simuler la connexion
            setTimeout(() => {
                showToast('Connexion réussie ! Redirection vers le paiement...', 'success');
                
                // Fermer la modal
                const modal = bootstrap.Modal.getInstance(loginModal);
                modal.hide();
                
                // Rediriger vers checkout (simulé ici, en vrai ce serait une vraie redirection)
                setTimeout(() => {
                    window.location.href = "{{ route('client.checkout') }}";
                }, 1500);
            }, 1000);
        });
    }
    
    // Fonction toast
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 p-3';
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
            if (toast.parentNode) toast.remove();
        }, 3000);
    }
});
</script>
@endsection