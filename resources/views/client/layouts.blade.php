<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ShopStore - Votre boutique en ligne')</title>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Icônes Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Police Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Styles personnalisés -->
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --accent-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --sidebar-width: 280px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #374151;
            min-height: 100vh;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        
        /* Navbar client */
        .navbar-client {
            background: linear-gradient(135deg, var(--dark-color) 0%, #111827 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand-client {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-brand-client i {
            font-size: 1.8rem;
        }
        
        /* Barre de recherche */
        .search-container {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .search-input-group {
            position: relative;
        }
        
        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border-radius: 50px;
            width: 100%;
            transition: all 0.3s;
        }
        
        .search-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            outline: none;
        }
        
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            pointer-events: none;
        }
        
        /* Liens navigation */
        .nav-icon-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s;
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .nav-icon-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
            min-width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Sidebar gauche FIXE */
        .sidebar-left {
            background: white;
            width: var(--sidebar-width);
            min-height: calc(100vh - 76px);
            border-right: 1px solid #e5e7eb;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            position: fixed;
            left: 0;
            top: 76px;
            z-index: 100;
            overflow-y: auto;
            padding: 0;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        
        .sidebar-header h5 {
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
            display: flex;
            align-items-center;
            gap: 10px;
        }
        
        .sidebar-section {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .sidebar-section:last-child {
            border-bottom: none;
        }
        
        .sidebar-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Catégories sidebar */
        .category-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 8px;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.3s;
            margin-bottom: 0.25rem;
        }
        
        .category-item:hover {
            background: #f3f4f6;
            color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .category-item.active {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .category-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border-radius: 6px;
            margin-right: 0.75rem;
            color: #6b7280;
        }
        
        .category-item:hover .category-icon {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
        }
        
        /* Panier sidebar - STYLES AMÉLIORÉS */
        .cart-items {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            background: #f9fafb;
            position: relative;
            transition: all 0.3s;
        }
        
        .cart-item:hover {
            background: #f0f9ff;
            transform: translateX(3px);
        }
        
        .cart-item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 0.75rem;
        }
        
        .cart-item-info {
            flex: 1;
        }
        
        .cart-item-title {
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        
        .cart-item-price {
            line-height: 1.4;
        }
        
        .cart-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
            margin-top: 1rem;
        }
        
        .cart-total-label {
            font-weight: 600;
            color: #374151;
        }
        
        .cart-total-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        /* Contenu principal */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: calc(100vh - 76px);
            padding: 2rem;
            background: #f9fafb;
            transition: margin-left 0.3s;
        }
        
        /* Cartes produits */
        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s;
            height: 100%;
            border: 1px solid #e5e7eb;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }
        
        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 1;
        }
        
        .badge-new {
            background: var(--accent-color);
            color: white;
        }
        
        .badge-sale {
            background: var(--danger-color);
            color: white;
        }
        
        .badge-hot {
            background: var(--warning-color);
            color: white;
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
        
        .product-rating {
            color: #f59e0b;
            font-size: 0.9rem;
        }
        
        /* Footer amélioré */
        .footer-client {
            background: linear-gradient(135deg, var(--dark-color) 0%, #111827 100%);
            color: white;
            padding: 3rem 0;
            margin-top: 3rem;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s;
        }
        
        .footer-section {
            margin-bottom: 2rem;
        }
        
        .footer-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: white;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .contact-info {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .social-link:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        /* Localisation */
        .location-widget {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .location-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: white;
        }
        
        .location-map {
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .location-address {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        /* Copyright */
        .copyright {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        
        /* Styles pour le panier sidebar amélioré */
        .badge-sm {
            font-size: 0.65rem;
            padding: 0.15rem 0.4rem;
        }
        
        .cart-item .badge-danger {
            position: absolute;
            top: 8px;
            right: 8px;
            animation: pulse-badge 2s infinite;
        }
        
        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .cart-item-price .text-decoration-line-through {
            font-size: 0.8rem;
        }
        
        .cart-item-price .text-success {
            font-size: 0.75rem;
        }
        
        /* Animation pour les nouveaux articles */
        @keyframes highlight-new {
            0% { background-color: rgba(16, 185, 129, 0.1); }
            100% { background-color: transparent; }
        }
        
        .cart-item.highlight {
            animation: highlight-new 2s ease-out;
        }
        
        /* Badge pour économies */
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 8px;
        }
        
        /* Prix promotionnel */
        .promotional-price {
            color: #ef4444;
            font-weight: bold;
        }
        
        .price-original {
            text-decoration: line-through;
            color: #9ca3af;
            font-size: 0.9rem;
        }
        
        .savings-badge {
            background: #10b981;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            :root {
                --sidebar-width: 250px;
            }
        }
        
        @media (max-width: 992px) {
            .sidebar-left {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1050;
            }
            
            .sidebar-left.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            .footer-client {
                margin-left: 0 !important;
            }
            
            .search-container {
                order: 3;
                width: 100%;
                margin-top: 1rem;
            }
            
            .navbar-collapse {
                padding-top: 1rem;
            }
            
            /* Bouton pour ouvrir la sidebar sur mobile */
            .sidebar-toggle {
                display: block !important;
            }
        }
        
        @media (min-width: 993px) {
            .sidebar-toggle {
                display: none !important;
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            
            .footer-section {
                margin-bottom: 2rem;
            }
        }
        
        /* Messages et alertes */
        .alert-client {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        /* Boutons */
        .btn-primary-client {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary-client:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }
        
        /* Filtres */
        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
        }
        
        .filter-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }
        
        /* Bouton toggle sidebar mobile */
        .sidebar-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            padding: 0.5rem;
            display: none;
        }
        
        /* Overlay pour mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
        
        /* Animation pulse */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-client">
    <div class="container-fluid">
        <!-- Bouton toggle sidebar (mobile) -->
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        
        <!-- Logo -->
        <a class="navbar-brand-client ms-2" href="{{ route('client.dashboard') }}">
            <i class="bi bi-shop"></i>
            <span>ShopStore</span>
        </a>
        
        <!-- Bouton menu mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarClient">
            <span class="navbar-toggler-icon">
                <i class="bi bi-list text-white"></i>
            </span>
        </button>
        
        <!-- Barre de recherche -->
        <div class="search-container collapse navbar-collapse" id="navbarSearch">
            <form method="GET" action="{{ route('client.dashboard') }}" class="w-100">
                <div class="search-input-group">
                    <i class="bi bi-search search-icon"></i>
                    <input type="search" 
                           name="search" 
                           class="search-input" 
                           placeholder="Rechercher un produit..."
                           value="{{ request('search') }}">
                </div>
            </form>
        </div>
        
        <!-- Actions utilisateur -->
        <div class="collapse navbar-collapse" id="navbarClient">
            <div class="navbar-nav ms-auto align-items-center gap-3">
                <!-- Recherche (mobile) -->
                <div class="d-lg-none w-100 mb-3">
                    <form method="GET" action="{{ route('client.dashboard') }}">
                        <div class="search-input-group">
                            <i class="bi bi-search search-icon"></i>
                            <input type="search" 
                                   name="search" 
                                   class="search-input" 
                                   placeholder="Rechercher..."
                                   value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
                
                <!-- Favoris -->
                <a href="#" class="nav-icon-link">
                    <i class="bi bi-heart fs-5"></i>
                </a>
                
                <!-- Panier -->
                <a href="{{ route('cart.index') }}" class="nav-icon-link position-relative">
                    <i class="bi bi-cart3 fs-5"></i>
                    @php
                        $cartCount = count(session('cart', []));
                    @endphp
                    @if($cartCount > 0)
                        <span class="cart-badge" id="cartBadge">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                
                <!-- Utilisateur -->
                @auth
                    <div class="dropdown">
                        <a class="nav-icon-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Mon compte</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-bag-check me-2"></i>Mes commandes</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-icon-link">
                        <i class="bi bi-box-arrow-in-right fs-5"></i>
                        <span class="d-none d-lg-inline ms-1">Connexion</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Overlay pour mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Structure principale -->
<div class="d-flex">
    <!-- Sidebar gauche FIXE -->
    <aside class="sidebar-left" id="sidebarLeft">
        <!-- Section catégories -->
        <div class="sidebar-section">
            <h6 class="sidebar-title">Catégories</h6>
            <div class="categories-list">
                <a href="{{ route('client.dashboard') }}" class="category-item {{ !request('category') ? 'active' : '' }}">
                    <div class="category-icon">
                        <i class="bi bi-grid"></i>
                    </div>
                    Tous les produits
                </a>
                @foreach($categories ?? [] as $category)
                    <a href="{{ route('client.dashboard', ['category' => $category->id]) }}" 
                       class="category-item {{ request('category') == $category->id ? 'active' : '' }}">
                        <div class="category-icon">
                            <i class="bi bi-{{ $category->icon ?? 'tag' }}"></i>
                        </div>
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <!-- Section panier (mini) - CORRIGÉE -->
        <div class="sidebar-section">
            <h6 class="sidebar-title">Mon panier</h6>

            <div class="cart-items">
                @php
                    $cartItems = session('cart', []);
                    $cartTotal = 0;
                    $totalSavings = 0;
                @endphp

                @if(count($cartItems) > 0)
                    @foreach(array_slice($cartItems, 0, 3) as $id => $item)
                        @php
                            // Vérifier si promotion active
                            $hasPromotion = isset($item['has_promotion']) && $item['has_promotion'];
                            $originalPrice = $item['original_price'] ?? $item['price'];
                            $discountPercent = $item['discount_percent'] ?? 0;
                            
                            // Calcul des totaux
                            $itemDisplayPrice = $item['price']; // Prix affiché (déjà réduit si promotion)
                            $itemDisplayTotal = $itemDisplayPrice * $item['quantity'];
                            $itemOriginalTotal = $originalPrice * $item['quantity'];
                            
                            // Calcul des économies pour cet article
                            if ($hasPromotion) {
                                $itemSavings = ($originalPrice - $itemDisplayPrice) * $item['quantity'];
                                $totalSavings += $itemSavings;
                            }
                            
                            $cartTotal += $itemDisplayTotal;
                        @endphp

                        <div class="cart-item" data-item-id="{{ $id }}">
                            <img 
                                src="{{ Str::startsWith($item['image'], 'http') ? $item['image'] : asset('storage/' . $item['image']) }}"
                                alt="{{ $item['name'] }}"
                                class="cart-item-image"
                                onerror="this.src='https://via.placeholder.com/50'"
                            >

                            <div class="cart-item-info">
                                <div class="cart-item-title">
                                    {{ Str::limit($item['name'], 20) }}
                                    @if($hasPromotion && $discountPercent > 0)
                                        <span class="badge bg-danger badge-sm ms-1">
                                            -{{ $discountPercent }}%
                                        </span>
                                    @endif
                                </div>

                                <div class="cart-item-price">
                                    @if($hasPromotion)
                                        <!-- Prix promotionnel -->
                                        <div class="d-flex align-items-center">
                                            <span class="promotional-price fw-bold me-2">
                                                {{ number_format($itemDisplayTotal, 2) }} DT
                                            </span>
                                            <small class="price-original">
                                                {{ number_format($itemOriginalTotal, 2) }}
                                            </small>
                                        </div>
                                        @if($itemSavings > 0)
                                            <small class="text-success d-block">
                                                <i class="bi bi-arrow-down me-1"></i>
                                                Économisé: {{ number_format($itemSavings, 2) }} DT
                                            </small>
                                        @endif
                                    @else
                                        <!-- Prix normal -->
                                        <span class="fw-bold">
                                            {{ number_format($itemDisplayTotal, 2) }} DT
                                        </span>
                                    @endif
                                    <small class="text-muted d-block">
                                        {{ $item['quantity'] }} × {{ number_format($itemDisplayPrice, 2) }} DT
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if(count($cartItems) > 3)
                        <div class="text-center mt-2">
                            <small class="text-muted">
                                <i class="bi bi-three-dots"></i>
                                + {{ count($cartItems) - 3 }} autre(s) article(s)
                            </small>
                        </div>
                    @endif

                    <!-- Total du panier -->
                    <div class="cart-total">
                        <span class="cart-total-label">Total:</span>
                        <span class="cart-total-price">
                            {{ number_format($cartTotal, 2) }} DT
                        </span>
                    </div>

                    <!-- Économies totales -->
                    @if($totalSavings > 0)
                        <div class="alert alert-success py-2 mt-2 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="fw-bold">
                                    <i class="bi bi-tag me-1"></i>Économies totales
                                </small>
                                <small class="fw-bold">
                                    -{{ number_format($totalSavings, 2) }} DT
                                </small>
                            </div>
                        </div>
                    @endif

                    <a href="{{ route('cart.index') }}" class="btn btn-primary-client w-100 mt-2">
                        <i class="bi bi-cart-check me-2"></i>
                        Voir le panier complet
                    </a>

                @else
                    <!-- Panier vide -->
                    <div class="text-center py-4">
                        <i class="bi bi-cart-x fs-1 text-muted mb-3"></i>
                        <p class="text-muted mb-2">Votre panier est vide</p>
                        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-shop me-1"></i>
                            Découvrir nos produits
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Section filtres -->
        <div class="sidebar-section">
            <h6 class="sidebar-title">Filtres</h6>
            <div class="mb-3">
                <label class="form-label small">Prix maximum</label>
                <input type="range" class="form-range" min="0" max="1000" value="500" id="priceRange">
                <div class="d-flex justify-content-between">
                    <small class="text-muted">0 DT</small>
                    <small class="text-muted" id="priceValue">10000 DT</small>
                </div>
            </div>
            <button class="btn btn-outline-primary w-100" id="applyFilters">
                <i class="bi bi-funnel me-2"></i>Appliquer les filtres
            </button>
        </div>
    </aside>
    
    <!-- Contenu principal -->
    <main class="main-content" id="mainContent">
        <!-- Messages flash -->
        @if(session('success'))
            <div class="alert alert-success alert-client">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-client">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('info'))
            <div class="alert alert-info alert-client">
                <i class="bi bi-info-circle-fill me-2"></i>
                {{ session('info') }}
            </div>
        @endif
        
        <!-- Contenu dynamique -->
        @yield('content')
    </main>
</div>

<!-- Footer amélioré -->
<footer class="footer-client">
    <div class="container">
        <div class="row">
            <!-- Section à propos -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="footer-section">
                    <h5 class="footer-title">ShopStore</h5>
                    <p class="text-light opacity-75">
                        Votre destination shopping en ligne. Nous proposons les meilleurs produits aux prix les plus compétitifs.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Liens rapides -->
            <div class="col-lg-2 col-md-6 mb-4">
                <div class="footer-section">
                    <h5 class="footer-title">Navigation</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('client.dashboard') }}" class="footer-link"><i class="bi bi-house"></i> Accueil</a></li>
                        <li><a href="{{ route('client.promotions') }}" class="footer-link"><i class="bi bi-percent"></i> Promotions</a></li>
                        <li><a href="#" class="footer-link"><i class="bi bi-tags"></i> Catégories</a></li>
                        <li><a href="#" class="footer-link"><i class="bi bi-star"></i> Nouveautés</a></li>
                        <li><a href="#" class="footer-link"><i class="bi bi-headset"></i> Support</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Contact -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="footer-section">
                    <h5 class="footer-title">Contactez-nous</h5>
                    <div class="contact-info">
                        <i class="bi bi-envelope"></i>
                        <div>
                            <div class="fw-medium">Email</div>
                            <div>contact@shopstore.com</div>
                        </div>
                    </div>
                    <div class="contact-info">
                        <i class="bi bi-telephone"></i>
                        <div>
                            <div class="fw-medium">Téléphone</div>
                            <div>+33 1 23 45 67 89</div>
                        </div>
                    </div>
                    <div class="contact-info">
                        <i class="bi bi-clock"></i>
                        <div>
                            <div class="fw-medium">Horaires</div>
                            <div>Lun-Ven: 9h-18h</div>
                            <div>Sam: 10h-17h</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Localisation -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-section">
                    <h5 class="footer-title">Notre localisation</h5>
                    <div class="location-widget">
                        <div class="location-title">
                            <i class="bi bi-geo-alt me-2"></i>Notre boutique
                        </div>
                        <div class="location-map">
                            <i class="bi bi-map fs-1"></i>
                        </div>
                        <div class="location-address">
                            <strong>ShopStore Paris</strong><br>
                            123 Avenue des Champs-Élysées<br>
                            75008 Paris, France<br>
                            <small class="text-muted">Métro: Charles de Gaulle - Étoile</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="row">
            <div class="col-12">
                <div class="copyright">
                    <p class="mb-0">
                        © {{ date('Y') }} ShopStore. Tous droits réservés.
                        <span class="d-block d-md-inline mt-2 mt-md-0">
                            <a href="#" class="text-light opacity-75 text-decoration-none mx-2">Mentions légales</a>
                            <a href="#" class="text-light opacity-75 text-decoration-none mx-2">Conditions d'utilisation</a>
                            <a href="#" class="text-light opacity-75 text-decoration-none mx-2">Politique de confidentialité</a>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Scripts personnalisés -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments DOM
        const sidebar = document.getElementById('sidebarLeft');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        const cartBadge = document.getElementById('cartBadge');
        
        // Gestion de la sidebar mobile
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        }
        
        // Événements
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }
        
        // Fermer la sidebar en cliquant sur un lien
        document.querySelectorAll('.sidebar-left a').forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth < 992 && !this.classList.contains('dropdown-toggle')) {
                    toggleSidebar();
                }
            });
        });
        
        // Mise à jour du prix sur le slider
        if (priceRange && priceValue) {
            priceRange.addEventListener('input', function() {
                priceValue.textContent = this.value + ' DT';
            });
        }
        
        // Appliquer les filtres
        const applyFiltersBtn = document.getElementById('applyFilters');
        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', function() {
                const price = priceRange ? priceRange.value : 500;
                showToast(`Filtres appliqués : prix maximum ${price} DT`, 'info');
            });
        }
        
        // Animation du badge panier
        function animateCartBadge() {
            if (cartBadge) {
                cartBadge.style.animation = 'pulse 0.5s';
                setTimeout(() => {
                    cartBadge.style.animation = '';
                }, 500);
            }
        }
        
        // Animation pour les catégories
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
            });
            
            item.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateX(0)';
                }
            });
        });
        
        // Animation des cartes produits
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Animation du footer
        document.querySelectorAll('.footer-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
        
        // Fonction toast améliorée
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 end-0 p-3';
            toast.style.zIndex = '1055';
            
            const bgColor = type === 'success' ? 'bg-success' : 
                           type === 'error' ? 'bg-danger' : 
                           type === 'warning' ? 'bg-warning' : 'bg-primary';
            
            const icon = type === 'success' ? 'bi-check-circle' : 
                        type === 'error' ? 'bi-exclamation-circle' : 
                        type === 'warning' ? 'bi-exclamation-triangle' : 'bi-info-circle';
            
            const title = type === 'success' ? 'Succès' : 
                         type === 'error' ? 'Erreur' : 
                         type === 'warning' ? 'Attention' : 'Information';
            
            toast.innerHTML = `
                <div class="toast show" role="alert">
                    <div class="toast-header ${bgColor} text-white border-0">
                        <i class="bi ${icon} me-2"></i>
                        <strong class="me-auto">${title}</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
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
        
        // Initialiser l'animation du badge si panier non vide
        if ({{ $cartCount ?? 0 }} > 0) {
            animateCartBadge();
        }
        
        // Ajuster le margin du main content et footer selon la sidebar
        function adjustLayout() {
            const sidebarWidth = window.getComputedStyle(document.documentElement)
                .getPropertyValue('--sidebar-width');
            
            if (window.innerWidth >= 992) {
                mainContent.style.marginLeft = sidebarWidth;
                document.querySelector('.footer-client').style.marginLeft = sidebarWidth;
            } else {
                mainContent.style.marginLeft = '0';
                document.querySelector('.footer-client').style.marginLeft = '0';
            }
        }
        
        // Ajuster au chargement et au redimensionnement
        adjustLayout();
        window.addEventListener('resize', adjustLayout);
        
        // Gestion de l'ajout au panier
        document.addEventListener('click', function(e) {
            const addToCartBtn = e.target.closest('.add-to-cart');
            if (addToCartBtn) {
                e.preventDefault();
                
                const form = addToCartBtn.closest('form');
                if (!form) return;
                
                const originalText = addToCartBtn.innerHTML;
                const originalClass = addToCartBtn.className;
                
                // Animation du bouton
                addToCartBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Ajouté';
                addToCartBtn.className = 'btn btn-success w-100';
                addToCartBtn.disabled = true;
                
                // Soumettre le formulaire après un délai
                setTimeout(() => {
                    form.submit();
                }, 500);
                
                // Mettre à jour le compteur du panier
                if (cartBadge) {
                    const currentCount = parseInt(cartBadge.textContent) || 0;
                    cartBadge.textContent = currentCount + 1;
                    animateCartBadge();
                }
                
                showToast('Produit ajouté au panier !', 'success');
            }
        });
        
        // Surligner un article dans le sidebar
        function highlightCartItem(productId) {
            const cartItems = document.querySelectorAll('.cart-item');
            cartItems.forEach(item => {
                if (item.getAttribute('data-item-id') == productId) {
                    item.classList.add('highlight');
                    setTimeout(() => {
                        item.classList.remove('highlight');
                    }, 2000);
                }
            });
        }
        
        // Recharger le sidebar panier (pour les mises à jour en temps réel)
        function reloadCartSidebar() {
            fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newCartSection = doc.querySelector('.sidebar-section:nth-child(2)');
                    if (newCartSection) {
                        document.querySelector('.sidebar-section:nth-child(2)').innerHTML = newCartSection.innerHTML;
                    }
                })
                .catch(error => console.error('Erreur lors du rechargement du panier:', error));
        }
        
        // Gestion des promotions expirées
        function checkExpiredPromotions() {
            const now = new Date();
            document.querySelectorAll('[data-promotion-end]').forEach(element => {
                const endDate = new Date(element.getAttribute('data-promotion-end'));
                if (endDate < now) {
                    element.classList.add('text-muted');
                    element.innerHTML = '<span class="badge bg-secondary">Expiré</span>';
                }
            });
        }
        
        // Exécuter les vérifications
        checkExpiredPromotions();
        
        // Rafraîchir le panier toutes les 30 secondes (pour les promotions dynamiques)
        setInterval(() => {
            if ({{ $cartCount ?? 0 }} > 0) {
                reloadCartSidebar();
            }
        }, 30000);
    });
</script>

@yield('scripts')
</body>
</html>