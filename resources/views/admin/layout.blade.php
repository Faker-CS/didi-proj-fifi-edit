<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | E-commerce Admin</title>
    <!-- Bootstrap 5.3 avec thème personnalisé e-commerce -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Icônes Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Police Google pour un look moderne -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --sidebar-width: 260px;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #374151;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        
        /* Navbar modernisée */
        .navbar-modern {
            background: linear-gradient(135deg, var(--dark-color) 0%, #111827 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .navbar-modern .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            width: 300px;
            transition: all 0.3s;
        }
        
        .navbar-modern .form-control:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            color: white;
        }
        
        .navbar-modern .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .user-avatar {
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s;
        }
        
        .user-avatar:hover {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }
        
        .logout-btn {
            color: rgba(255, 255, 255, 0.8) !important;
            text-decoration: none;
            transition: all 0.3s;
            padding: 0.5rem 1rem;
            border-radius: 6px;
        }
        
        .logout-btn:hover {
            color: white !important;
            background-color: rgba(239, 68, 68, 0.2);
            text-decoration: none;
        }
        
        /* Sidebar modernisée */
        .sidebar-modern {
            background: white;
            width: var(--sidebar-width);
            min-height: calc(100vh - 70px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            border-right: 1px solid #e5e7eb;
            position: relative;
            z-index: 10;
        }
        
        .sidebar-header {
            padding: 1.5rem 1.25rem 0.5rem;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 1rem;
        }
        
        .sidebar-modern h5 {
            color: var(--dark-color);
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }
        
        .nav-link-sidebar {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            color: #4b5563;
            border-radius: 8px;
            margin: 0.25rem 0.75rem;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .nav-link-sidebar:hover {
            background-color: #f3f4f6;
            color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .nav-link-sidebar.active {
            background-color: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .nav-link-sidebar i {
            margin-right: 10px;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }
        
        /* Contenu principal */
        .main-content {
            padding: 1.5rem 2rem;
            width: calc(100% - var(--sidebar-width));
            background-color: #f9fafb;
            min-height: calc(100vh - 70px);
        }
        
        .content-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            border: 1px solid #e5e7eb;
            margin-bottom: 1.5rem;
        }
        
        /* Badges pour statistiques */
        .stat-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: #f0f9ff;
            color: #0369a1;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .stat-badge i {
            margin-right: 0.5rem;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar-modern {
                width: 70px;
            }
            
            .sidebar-modern .nav-text {
                display: none;
            }
            
            .sidebar-header h5 {
                display: none;
            }
            
            .sidebar-header {
                padding: 1.5rem 0.5rem 0.5rem;
                text-align: center;
            }
            
            .main-content {
                width: calc(100% - 70px);
            }
            
            .nav-link-sidebar {
                justify-content: center;
                padding: 0.75rem;
                margin: 0.25rem 0.5rem;
            }
            
            .nav-link-sidebar i {
                margin-right: 0;
            }
        }
        
        @media (max-width: 768px) {
            .navbar-modern .form-control {
                width: 200px;
            }
        }
        
        @media (max-width: 576px) {
            .navbar-modern .form-control {
                width: 150px;
            }
            
            .main-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar modernisée -->
    <nav class="navbar navbar-modern navbar-expand-lg px-3">
        <div class="container-fluid">
            <!-- Logo/Brand (optionnel) -->
            <a class="navbar-brand d-none d-md-block text-white fw-bold" href="{{Route('admin.dashboard')}}">
                <i class="bi bi-shop me-2"></i>AdminStore
            </a>
            
            <!-- Formulaire de recherche -->
            <form class="d-flex align-items-center position-relative">
                <i class="bi bi-search position-absolute text-white-50" style="left: 12px;"></i>
                <input class="form-control ps-4" type="search" placeholder="   Rechercher un produit, commande, client...">
            </form>

            <!-- Section utilisateur -->
            <div class="d-flex align-items-center">
                <!-- Notification (optionnel) -->
                <button class="btn btn-link text-white me-2 position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem; padding: 0.25rem 0.4rem;">
                        3
                    </span>
                </button>
                
                <!-- Avatar utilisateur -->
                <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'Admin').'&background=6366f1&color=fff&bold=true' }}"
                     class="rounded-circle user-avatar me-2" width="40" height="40" alt="Avatar">
                
                <!-- Bouton déconnexion -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link logout-btn">
                        <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar modernisée -->
        <div class="sidebar-modern">
            <div class="sidebar-header">
                <h5><i class="bi bi-speedometer2 me-2"></i> Tableau de bord</h5>
            </div>
            
            <div class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}" class="nav-link-sidebar {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span class="nav-text">Accueil</span>
                </a>
                
                <a href="{{ route('admin.categories') }}" class="nav-link-sidebar {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span class="nav-text">Catégories</span>
                </a>
                
                <a href="{{ route('admin.orders') }}" class="nav-link-sidebar {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <i class="bi bi-cart"></i>
                    <span class="nav-text">Commandes</span>
                    <span class="ms-auto stat-badge">12</span>
                </a>
                
                <a href="{{ route('admin.promotions.create') }}" class="nav-link-sidebar {{ request()->routeIs('admin.promotions.create') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span class="nav-text">Promotions</span>
                </a>
                
                <a href="{{ route('admin.analytics') }}" class="nav-link-sidebar {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart"></i>
                    <span class="nav-text">Analytiques</span>
                </a>
                
                <div class="mt-auto p-3">
                    <div class="content-card">
                        <small class="text-muted d-block">Ventes du jour</small>
                        <h4 class="fw-bold text-success">1999.5DT</h4>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> 12% vs hier
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="main-content">
            <!-- En-tête de la page -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">@yield('page-title', 'Tableau de bord')</h2>
                    <p class="text-muted mb-0">@yield('page-subtitle', 'Gérez votre boutique en ligne')</p>
                </div>
                
                <div>
                    <span class="stat-badge me-2">
                        <i class="bi bi-calendar-week"></i> {{ now()->format('d/m/Y') }}
                    </span>
                    <span class="stat-badge">
                        <i class="bi bi-clock"></i> {{ now()->format('H:i') }}
                    </span>
                </div>
            </div>
            
            <!-- Contenu dynamique -->
            <div class="content-card">
                @yield('content')
            </div>
            
            <!-- Pied de page optionnel -->
            <footer class="mt-4 text-center text-muted">
                <small>© {{ date('Y') }} AdminStore. Système de gestion e-commerce.</small>
            </footer>
        </div>
    </div>

    <!-- Bootstrap Bundle avec Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Scripts personnalisés -->
    <script>
        // Active le lien sidebar correspondant à la page actuelle
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link-sidebar');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
            
            // Mise à jour de l'heure en temps réel
            function updateTime() {
                const now = new Date();
                const timeElement = document.querySelector('.stat-badge i.bi-clock').parentElement;
                if (timeElement) {
                    const hours = now.getHours().toString().padStart(2, '0');
                    const minutes = now.getMinutes().toString().padStart(2, '0');
                    timeElement.innerHTML = `<i class="bi bi-clock"></i> ${hours}:${minutes}`;
                }
            }
            
            setInterval(updateTime, 60000);
        });
    </script>
</body>
</html>