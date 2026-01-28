@extends('admin.layout')

@section('title', 'Produits')

@section('content')
<div class="container mt-5">

    <h1 class="mb-4 text-center">🛒 Produits</h1>

    <div class="mb-3 text-end">
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
            ➕ Ajouter un produit
        </a>
    </div>

    <table class="table table-striped table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Catégorie</th>
                <th>Stock</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <img src="{{ Str::startsWith($product->image, 'http') 
                        ? $product->image 
                        : asset('storage/' . $product->image) }}"
                    width="60"
                    alt="{{ $product->name }}" >

                </td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price, 2) }} DT</td>
                <td>{{ $product->category->name ?? '—' }}</td>
                <td>{{ $product->stock }}</td>
                <td class="text-center">
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                       class="btn btn-sm btn-warning">
                        Éditer
                    </a>

                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Supprimer ce produit ?')">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted">
                    Aucun produit disponible.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
