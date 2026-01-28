<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos produits</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <!-- Titre -->
    <h1 class="text-center mb-4">🛒 Nos produits</h1>

    <div class="row">

        {{-- Boucle sur les produits --}}
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">

                    <!-- Image -->
                    @if($product->image)
                        <img src="{{ $product->image }}" 
                             class="card-img-top" 
                             alt="{{ $product->name }}" 
                             style="height:280px; object-fit:cover;">
                    @else
                        <img src="https://via.placeholder.com/400x200?text=Pas+d+image" 
                             class="card-img-top" 
                             alt="Pas d'image">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <!-- Nom -->
                        <h5 class="card-title">{{ $product->name }}</h5>

                        <!-- Prix -->
                        <p class="card-text fw-bold text-success">
                            {{ number_format($product->price, 2) }} DT
                        </p>

                        <!-- Boutons -->
                        <div class="mt-auto">
                            <!-- Voir produit -->
                            <a href="{{ route('products.show', $product) }}"
                               class="btn btn-primary btn-sm w-100 mb-2">
                                Voir
                            </a>

                            <!-- Ajouter au panier -->
                            <form method="POST" action="{{ route('cart.add', $product) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    Ajouter au panier
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <p class="text-center text-muted">Aucun produit disponible</p>
        @endforelse

    </div>
</div>

</body>
</html>
