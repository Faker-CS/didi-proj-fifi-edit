@extends('admin.layout')

@section('title','Détails commande')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Commande #{{ $order->id }}</h1>

    <p><strong>Client :</strong> {{ $order->user->name }}</p>
    <p><strong>Total :</strong> {{ number_format($order->total,2) }} DT</p>
    <p><strong>Statut :</strong> {{ $order->status }}</p>

    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="mb-3">
        @csrf
        @method('PUT')
        <select name="status" class="form-select w-25 d-inline">
            <option value="en cours" {{ $order->status=='en cours'?'selected':'' }}>En cours</option>
            <option value="expédié" {{ $order->status=='expédié'?'selected':'' }}>Expédié</option>
            <option value="livré" {{ $order->status=='livré'?'selected':'' }}>Livré</option>
        </select>
        <button type="submit" class="btn btn-success btn-sm">Mettre à jour</button>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price,2) }} DT</td>
                <td>{{ number_format($item->price * $item->quantity,2) }} DT</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
