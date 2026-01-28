@extends('client.layouts')

@section('title', 'Paiement')

@section('content')
<div class="container mt-5">
    <h2>🧾 Finaliser la commande</h2>

    <form method="POST" action="{{ route('client.checkout.store') }}">
        @csrf

        <h5 class="mt-4">Mode de paiement</h5>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="cash">
            <label class="form-check-label">💵 Paiement à la livraison</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="card">
            <label class="form-check-label">💳 Carte bancaire (simulation)</label>
        </div>

        <button class="btn btn-success mt-4 w-100">
            Confirmer la commande
        </button>
    </form>
</div>
@endsection