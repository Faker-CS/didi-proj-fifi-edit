@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Aperçu général de votre boutique')

@section('content')
<div class="container-fluid">

    <!-- Statistiques principales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Produits</h6>
                            <h2 class="fw-bold mb-0">{{ $products->count() }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-box-seam text-primary fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.products') }}" class="text-decoration-none text-primary">
                            Voir tous les produits <i class="bi bi-arrow-right-short"></i>
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
                            <h6 class="text-muted mb-1">Catégories</h6>
                            <h2 class="fw-bold mb-0">{{ $categories->count() }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-tags text-success fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.categories') }}" class="text-decoration-none text-success">
                            Gérer les catégories <i class="bi bi-arrow-right-short"></i>
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
                            <h6 class="text-muted mb-1">Commandes du jour</h6>
                            <h2 class="fw-bold mb-0">{{ $dailyOrders ?? 0 }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-cart text-warning fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">
                            <i class="bi bi-arrow-up-short text-success"></i> +12% vs hier
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-info border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Revenus du jour</h6>
                            <h2 class="fw-bold mb-0">{{ number_format($dailyRevenue ?? 0, 2) }}DT</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-currency-euro text-info fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">
                            <i class="bi bi-arrow-up-short text-success"></i> +8% vs semaine dernière
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et statistiques -->
    <div class="row mb-4">
        <!-- Distribution par catégorie -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-semibold">Distribution des produits par catégorie</h6>
                </div>
                <div class="card-body">
                    @if($categories->count() > 0)
                        <div style="height: 250px;">
                            <div class="row align-items-center h-100">
                                @foreach($categories as $category)
                                    @php
                                        $categoryProducts = $products->where('category_id', $category->id)->count();
                                        $percentage = $products->count() > 0 ? ($categoryProducts / $products->count() * 100) : 0;
                                        $colors = ['#6366f1', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444', '#3b82f6'];
                                        $color = $colors[$loop->index % count($colors)];
                                    @endphp
                                    <div class="col-6 mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="fw-medium">{{ $category->name }}</span>
                                            <span class="text-muted">{{ $categoryProducts }} produits</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar rounded" 
                                                 role="progressbar" 
                                                 style="width: {{ $percentage }}%; background-color: {{ $color }};"
                                                 aria-valuenow="{{ $percentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ number_format($percentage, 1) }}% du total</small>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-pie-chart fs-1 text-muted mb-3"></i>
                            <p class="text-muted">Aucune catégorie disponible</p>
                            <a href="{{ route('admin.categories') }}" class="btn btn-primary btn-sm">
                                Créer une catégorie
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistiques de stock -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-semibold">État du stock</h6>
                </div>
                <div class="card-body">
                    @php
                        $lowStock = $products->where('stock', '<=', 5)->where('stock', '>', 0)->count();
                        $outOfStock = $products->where('stock', 0)->count();
                        $inStock = $products->where('stock', '>', 5)->count();
                        $totalProducts = $products->count();
                    @endphp
                    
                    <div class="row text-center mb-4">
                        <div class="col-4">
                            <div class="p-3 bg-success bg-opacity-10 rounded">
                                <h3 class="fw-bold text-success">{{ $inStock }}</h3>
                                <small class="text-muted">En stock</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 bg-warning bg-opacity-10 rounded">
                                <h3 class="fw-bold text-warning">{{ $lowStock }}</h3>
                                <small class="text-muted">Stock faible</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 bg-danger bg-opacity-10 rounded">
                                <h3 class="fw-bold text-danger">{{ $outOfStock }}</h3>
                                <small class="text-muted">Rupture</small>
                            </div>
                        </div>
                    </div>

                    @if($lowStock > 0)
                        <div class="alert alert-warning">
                            <div class="d-flex">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <div>
                                    <strong>Attention :</strong> {{ $lowStock }} produit(s) ont un stock faible
                                    (≤ 5 unités).
                                    <a href="#" class="alert-link">Vérifier le stock</a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($outOfStock > 0)
                        <div class="alert alert-danger">
                            <div class="d-flex">
                                <i class="bi bi-x-circle me-2"></i>
                                <div>
                                    <strong>Rupture de stock :</strong> {{ $outOfStock }} produit(s) sont en rupture.
                                    <a href="#" class="alert-link">Réapprovisionner</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Produits les plus vus/achetés -->
    <div class="row">
        <div class="col-xl-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold">Produits populaires</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                data-bs-toggle="dropdown">
                            Cette semaine
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                            <li><a class="dropdown-item" href="#">Cette semaine</a></li>
                            <li><a class="dropdown-item" href="#">Ce mois</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Catégorie</th>
                                    <th>Prix</th>
                                    <th>Stock</th>
                                    <th>Popularité</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products->take(5) as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $product->image ?: 'https://via.placeholder.com/40' }}" 
                                                     alt="{{ $product->name }}"
                                                     class="rounded me-3" width="40" height="40">
                                                <div>
                                                    <div class="fw-medium">{{ $product->name }}</div>
                                                    <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $product->category->name ?? '—' }}
                                            </span>
                                        </td>
                                        <td class="fw-semibold">{{ number_format($product->price, 2) }} DT</td>
                                        <td>
                                            @if($product->stock == 0)
                                                <span class="badge bg-danger">Rupture</span>
                                            @elseif($product->stock <= 5)
                                                <span class="badge bg-warning">{{ $product->stock }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $product->stock }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $popularity = rand(70, 100);
                                                $width = $popularity . '%';
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                    <div class="progress-bar bg-primary" 
                                                         style="width: {{ $width }}"></div>
                                                </div>
                                                <small class="text-muted">{{ $popularity }}%</small>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="bi bi-box-seam fs-1 text-muted mb-2"></i>
                                            <p class="text-muted">Aucun produit disponible</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="col-xl-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-semibold">Actions rapides</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                       
                        
                        <a href="{{ route('admin.categories') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-folder-plus me-2"></i> Nouvelle catégorie
                        </a>
                        
                        <a href="{{ route('admin.analytics') }}" class="btn btn-outline-success btn-lg">
                            <i class="bi bi-bar-chart me-2"></i> Voir les rapports
                        </a>
                        
                        <a href="{{ route('admin.promotions.create') }}" class="btn btn-outline-warning btn-lg">
                            <i class="bi bi-megaphone me-2"></i> Promotions
                        </a>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-semibold mb-3">Rappels</h6>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-clock text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <small class="text-muted">À faire aujourd'hui</small>
                                    <div class="fw-medium">Vérifier les stocks bas</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-calendar-week text-warning"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <small class="text-muted">Cette semaine</small>
                                    <div class="fw-medium">Mettre à jour les prix</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Styles additionnels pour cette page -->
<style>
    .progress {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .progress-bar {
        border-radius: 10px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(99, 102, 241, 0.05);
    }
    
    .badge {
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    
    .alert {
        border: none;
        border-radius: 10px;
    }
    
    .list-group-item {
        border-left: none;
        border-right: none;
    }
    
    .list-group-item:first-child {
        border-top: none;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }
</style>

<script>
    // Animation des nombres dans les statistiques
    document.addEventListener('DOMContentLoaded', function() {
        // Animer les compteurs
        const counters = document.querySelectorAll('.fw-bold.mb-0');
        counters.forEach(counter => {
            const target = parseInt(counter.textContent.replace(/\D/g, ''));
            if (!isNaN(target)) {
                animateCounter(counter, target);
            }
        });
    });

    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, 30);
    }
</script>
@endsection