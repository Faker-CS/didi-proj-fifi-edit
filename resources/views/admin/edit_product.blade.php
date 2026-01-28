@extends('admin.layout')

@section('title','Éditer produit')

@section('content')
<h1 class="mb-4">✏️ Éditer : {{ $product->name }}</h1>

<form method="POST" action="{{ route('admin.products.update',$product->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name',$product->name) }}">
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description',$product->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label>Prix</label>
        <input type="number" name="price" class="form-control"
               value="{{ old('price',$product->price) }}">
    </div>

    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" class="form-control"
               value="{{ old('stock',$product->stock) }}">
    </div>

    <div class="mb-3">
        <label>Catégorie</label>
        <select name="category_id" class="form-select">
            <option value="">Aucune</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ $product->category_id==$category->id?'selected':'' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Image (URL)</label>
        <input type="text" name="image" class="form-control"
               value="{{ old('image',$product->image) }}">
    </div>

    <button class="btn btn-success">Mettre à jour</button>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

</form>
@endsection
</div>