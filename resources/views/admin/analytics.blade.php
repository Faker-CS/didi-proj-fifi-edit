@extends('admin.layout')

@section('title', 'Analytique')

@section('content')
<div class="container-fluid px-4">

    <!-- En-tête avec titre et filtre temporel -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">📈 Tableau de bord analytique</h1>
            <p class="text-muted mb-0">Vue d'ensemble des performances et statistiques</p>
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="timeRangeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-calendar-alt me-2"></i>Cette semaine
            </button>
            <ul class="dropdown-menu" aria-labelledby="timeRangeDropdown">
                <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                <li><a class="dropdown-item" href="#">Cette semaine</a></li>
                <li><a class="dropdown-item" href="#">Ce mois</a></li>
                <li><a class="dropdown-item" href="#">Cette année</a></li>
            </ul>
        </div>
    </div>

    <!-- Statistiques générales avec cartes modernes -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-primary shadow-hover h-100 py-2 animate-on-load">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Produits
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $productsCount }}</div>
                            <div class="mt-2">
                                <span class="text-success small">
                                    <i class="fas fa-arrow-up me-1"></i>5.2%
                                </span>
                                <span class="text-muted small">depuis le mois dernier</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-primary-light">
                                <i class="fas fa-box text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-success shadow-hover h-100 py-2 animate-on-load" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Catégories
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $categoriesCount }}</div>
                            <div class="mt-2">
                                <span class="text-success small">
                                    <i class="fas fa-arrow-up me-1"></i>2.1%
                                </span>
                                <span class="text-muted small">depuis le mois dernier</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-success-light">
                                <i class="fas fa-tags text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-warning shadow-hover h-100 py-2 animate-on-load" style="animation-delay: 0.2s">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                Clients
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $clientsCount }}</div>
                            <div class="mt-2">
                                <span class="text-success small">
                                    <i class="fas fa-arrow-up me-1"></i>12.4%
                                </span>
                                <span class="text-muted small">depuis le mois dernier</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-warning-light">
                                <i class="fas fa-users text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-info shadow-hover h-100 py-2 animate-on-load" style="animation-delay: 0.3s">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                Commandes
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $ordersCount }}</div>
                            <div class="mt-2">
                                <span class="text-success small">
                                    <i class="fas fa-arrow-up me-1"></i>8.7%
                                </span>
                                <span class="text-muted small">depuis le mois dernier</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-info-light">
                                <i class="fas fa-shopping-cart text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Métriques de performance -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-gradient-primary shadow-lg h-100 animate-on-load" style="animation-delay: 0.4s">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="metric-icon">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title text-white mb-0">Aujourd'hui</h5>
                            <p class="text-white-50 small mb-0">Commandes passées</p>
                        </div>
                    </div>
                    <h2 class="text-white mb-0">{{ $ordersToday }}</h2>
                    <div class="progress mt-3 bg-white-25" style="height: 6px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: {{ min(100, ($ordersToday / max(1, $ordersToday + 10)) * 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-gradient-success shadow-lg h-100 animate-on-load" style="animation-delay: 0.5s">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="metric-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title text-white mb-0">Ce mois</h5>
                            <p class="text-white-50 small mb-0">Commandes passées</p>
                        </div>
                    </div>
                    <h2 class="text-white mb-0">{{ $ordersMonth }}</h2>
                    <div class="progress mt-3 bg-white-25" style="height: 6px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: {{ min(100, ($ordersMonth / max(1, $ordersMonth + 50)) * 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12 mb-4">
            <div class="card card-gradient-dark shadow-lg h-100 animate-on-load" style="animation-delay: 0.6s">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="metric-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title text-white mb-0">Chiffre d'affaires</h5>
                            <p class="text-white-50 small mb-0">Total des ventes</p>
                        </div>
                    </div>
                    <h2 class="text-white mb-0">{{ number_format($totalRevenue, 2) }} <small class="fs-6">DT</small></h2>
                    <div class="progress mt-3 bg-white-25" style="height: 6px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top produits avec graphique -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-fire text-warning me-2"></i>Produits les plus vendus
                    </h5>
                    <div>
                        <span class="badge bg-light text-dark me-2">
                            <i class="fas fa-filter me-1"></i>30 jours
                        </span>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Produit</th>
                                    <th class="border-0 text-center">Quantité vendue</th>
                                    <th class="border-0 text-center">Performance</th>
                                    <th class="border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $item)
                                    <tr class="animate-row">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="product-avatar">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $item->product->name ?? '—' }}</h6>
                                                    <small class="text-muted">#PROD{{ str_pad($item->product->id ?? '000', 4, '0', STR_PAD_LEFT) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary rounded-pill px-3 py-2">{{ $item->total_qty }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                @php
                                                    $maxQty = $topProducts->max('total_qty');
                                                    $percentage = $maxQty > 0 ? ($item->total_qty / $maxQty) * 100 : 0;
                                                @endphp
                                                <div class="progress flex-grow-1 me-2" style="height: 8px; max-width: 100px;">
                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ round($percentage) }}%</small>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-chart-bar fa-2x text-muted mb-3"></i>
                                                <p class="text-muted">Aucune donnée disponible</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($topProducts->count() > 0)
                <div class="card-footer bg-white border-0">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Affichage de {{ $topProducts->count() }} produits</small>
                        <a href="{{ route('admin.orders') }}" class="small">Voir tous les produits <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Aperçu rapide des commandes -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-info me-2"></i>Dernières activités
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Nouvelle commande</h6>
                                <p class="text-muted small mb-0">Commande #ORD-0012 reçue</p>
                                <small class="text-muted">Il y a 10 minutes</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Produit ajouté</h6>
                                <p class="text-muted small mb-0">Nouveau produit "Smartphone X" ajouté</p>
                                <small class="text-muted">Il y a 2 heures</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Stock faible</h6>
                                <p class="text-muted small mb-0">Stock de "Casque Bluetooth" en alerte</p>
                                <small class="text-muted">Il y a 5 heures</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Nouveau client</h6>
                                <p class="text-muted small mb-0">Ahmed Ben Ali s'est inscrit</p>
                                <small class="text-muted">Il y a 1 jour</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Styles CSS pour le design moderne -->
<style>
:root {
    --primary: #4361ee;
    --primary-light: #eef2ff;
    --success: #10b981;
    --success-light: #d1fae5;
    --warning: #f59e0b;
    --warning-light: #fef3c7;
    --info: #0ea5e9;
    --info-light: #e0f2fe;
    --dark: #1e293b;
}

/* Animations */
.animate-on-load {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s ease forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-row {
    transition: all 0.3s ease;
}

.animate-row:hover {
    transform: translateX(5px);
    background-color: #f8f9fa;
}

/* Cartes avec effet au survol */
.shadow-hover {
    transition: all 0.3s ease;
}

.shadow-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

/* Icônes dans les cartes */
.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.bg-primary-light { background-color: var(--primary-light); }
.bg-success-light { background-color: var(--success-light); }
.bg-warning-light { background-color: var(--warning-light); }
.bg-info-light { background-color: var(--info-light); }

/* Dégradés pour les cartes */
.card-gradient-primary {
    background: linear-gradient(135deg, var(--primary), #3a56d4);
    border: none;
}

.card-gradient-success {
    background: linear-gradient(135deg, var(--success), #0da271);
    border: none;
}

.card-gradient-dark {
    background: linear-gradient(135deg, var(--dark), #0f172a);
    border: none;
}

/* Icônes métriques */
.metric-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

/* Avatar produit */
.product-avatar {
    width: 40px;
    height: 40px;
    background-color: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 11px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
}

.timeline-marker {
    position: absolute;
    left: -36px;
    top: 5px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.timeline-content {
    padding-left: 10px;
}

/* État vide */
.empty-state {
    text-align: center;
    padding: 40px 20px;
}

/* Barres de progression */
.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}

.bg-gradient-warning {
    background: linear-gradient(90deg, #f59e0b, #fbbf24);
}

/* Responsive */
@media (max-width: 768px) {
    .metric-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    
    .icon-circle {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
}
</style>

<!-- Ajout d'icônes FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Script pour les animations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation au chargement
    const animateElements = document.querySelectorAll('.animate-on-load');
    animateElements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Effet de survol pour les lignes du tableau
    const tableRows = document.querySelectorAll('.animate-row');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});
</script>
@endsection