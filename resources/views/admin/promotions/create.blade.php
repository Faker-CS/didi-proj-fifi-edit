@extends('admin.layout')

@section('title', 'Ajouter une promotion')

@section('content')
<div class="container mt-5">

    <h2 class="mb-4">🏷️ Ajouter une promotion</h2>

    <form method="POST" action="{{ route('admin.promotions.store') }}">
        @csrf

        <div class="mb-3">
            <label>Produit</label>
            <select name="product_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} ({{ $product->price }} DT)
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Réduction (%)</label>
            <input type="number" name="discount_percent"
                   class="form-control" min="1" max="90" required>
        </div>

        <div class="mb-3">
            <label>Date début</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Date fin</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <button class="btn btn-success">Ajouter la promotion</button>
        
    </form>
    

</div>
@endsection
