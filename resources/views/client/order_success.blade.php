@extends('client.layouts')

@section('title', 'Commande réussie - ShopStore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">

            <!-- Icône succès -->
            <div class="mb-4">
                <i class="bi bi-check-circle-fill text-success display-1"></i>
            </div>

            <h1 class="fw-bold mb-3">Merci pour votre commande ! 🎉</h1>
            <p class="text-muted mb-4">
                Votre commande a été enregistrée avec succès. Vous recevrez un email de confirmation sous peu.
            </p>

            <!-- Résumé commande -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Résumé de la commande</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Numéro de commande :</span>
                           // <strong>#{{ $order->id }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Date :</span>
                            //<strong>{{ $order->created_at->format('d/m/Y H:i') }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Montant total :</span>
                            <strong>{{ number_format($order->total, 2) }} DT</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Statut :</span>
                            <strong class="text-primary">{{ ucfirst($order->status) }}</strong>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Liste des produits -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Produits commandés</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($order->items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $item->product->name }}</strong> <br>
                                Quantité : {{ $item->quantity }}
                            </div>
                            <span>{{ number_format($item->price * $item->quantity, 2) }} DT</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <a href="{{ route('client.dashboard') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-left me-2"></i>Retour aux produits
            </a>

        </div>
    </div>
</div>
@endsection