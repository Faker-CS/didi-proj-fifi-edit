@extends('admin.layout')

@section('title','Commandes')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">📦 Commandes</h1>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ number_format($order->total,2) }} DT</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                        Détails
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Aucune commande</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
