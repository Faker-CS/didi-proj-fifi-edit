<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }}</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <!-- Bouton retour -->
    <a href="{{ url('/') }}" class="btn btn-secondary mb-3">
        ← Retour aux produits
    </a>

    <div class="row">
        <div class="col-md-6">

            <!-- Image du produit -->
            <div class="border rounded p-4 text-center bg-light">
                @if($product->image)
                    <img src="{{ $product->image }}" 
                         class="img-fluid rounded" 
                         alt="{{ $product->name }}" 
                         style="max-height:400px; object-fit:cover;">
                @else
                    <img src="https://via.placeholder.com/400x300?text=Pas+d+image" 
                         class="img-fluid rounded" 
                         alt="Pas d'image">
                @endif
            </div>

        </div>

        <div class="col-md-6">

            <!-- Nom -->
            <h2>{{ $product->name }}</h2>

            <!-- Prix -->
            <h4 class="text-success fw-bold">
                {{ number_format($product->price, 2) }} DT
            </h4>

            <!-- Description -->
            <p class="mt-3">
                {{ $product->description ?? 'Aucune description disponible.' }}
            </p>

            <!-- Catégorie -->
            @if($product->category)
                <p>
                    <strong>Catégorie :</strong>
                    {{ $product->category->name }}
                </p>
            @endif

            <!-- Ajouter au panier -->
            <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf
                <button class="btn btn-success mt-3">
                    Ajouter au panier
                </button>
            </form>

        </div>
    </div>

</div>

</body>
</html>
