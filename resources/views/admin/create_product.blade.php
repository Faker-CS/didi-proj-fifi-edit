@extends('admin.layout')

@section('title', 'Ajouter un produit')

@section('content')
<div class="container mt-4">

    <h1 class="mb-4">➕ Ajouter un produit</h1>

    {{-- Erreurs --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="name"
                   class="form-control"
                   value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description"
                      class="form-control"
                      rows="3" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Prix (DT)</label>
            <input type="number" step="0.01"
                   name="price"
                   class="form-control"
                   value="{{ old('price') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number"
                   name="stock"
                   class="form-control"
                   value="{{ old('stock') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <select name="category_id" class="form-select">
                <option value="">— Aucune —</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Image (URL)</label>
            <input type="text"
                   name="image"
                   class="form-control"
                   placeholder="https://exemple.com/image.jpg"
                   value="{{ old('image') }}">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                💾 Ajouter
            </button>
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
             @endif

            <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>

    </form>
</div>
@endsection
