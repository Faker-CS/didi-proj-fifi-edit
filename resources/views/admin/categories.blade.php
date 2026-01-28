@extends('admin.layout')

@section('title', 'Catégories')

@section('content')
<div class="container mt-5">

    <h1 class="mb-4 text-center">📂 Catégories</h1>

    {{-- Message succès --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Erreurs --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire ajout catégorie --}}
    <div class="card mb-4">
        <div class="card-header">
            ➕ Ajouter une catégorie
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Nom de la catégorie"
                               required>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success w-100">
                            Ajouter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Liste des catégories --}}
    <div class="row">
        @forelse($categories as $category)
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <a href="{{ route('admin.products', ['category_id' => $category->id]) }}"
                           class="btn btn-primary btn-sm mt-2">
                            Voir les produits
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Aucune catégorie disponible.</p>
        @endforelse
    </div>

</div>
@endsection
