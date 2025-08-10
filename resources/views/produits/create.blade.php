@extends('layouts.app')

@section('title', 'produits')

@section('content')

    @php
        $user = auth()->user();
        $canCreate = $user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique';
    @endphp

    @if (!$canCreate)
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Accès refusé',
                text: 'Vous n\'avez pas la permission de créer un produit.',
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then(() => {
                window.location.href = "{{ route('produits.index') }}";
            });
        </script>
    @else
        <h2>Ajouter / Créer un nouveau produit</h2>




        <form action="{{ route('produits.store') }}" method="POST">
            @csrf

            <div>
                <label for="codeproduit">Code Produit</label>
                <input type="text" name="codeproduit" id="codeproduit" required pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" value="{{ old('codeproduit') }}">
                @error('codeproduit')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="libelle">Libellé</label>
                <input type="text" name="libelle" id="libelle" required pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" value="{{ old('libelle') }}">
                @error('libelle')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="conditionnement">Conditionnement</label>
                <input type="text" name="conditionnement" id="conditionnement" required pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" value="{{ old('conditionnement') }}">
                @error('conditionnement')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="quantitestock">Quantité</label>
                <input type="number" name="quantitestock" id="quantitestock" min="0" required
                    value="{{ old('quantitestock') }}">
                @error('quantitestock')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="stockmax">Stock maximum</label>
                <input type="number" name="stockmax" id="stockmax" min="0" required value="{{ old('stockmax') }}">
                @error('stockmax')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="stockmin">Stock minimum</label>
                <input type="number" name="stockmin" id="stockmin" min="0" required value="{{ old('stockmin') }}">
                @error('stockmin')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="stocksecurite">Stock de sécurité</label>
                <input type="number" name="stocksecurite" id="stocksecurite" min="0" required
                    value="{{ old('stocksecurite') }}">
                @error('stocksecurite')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="dateperemption">Date de péremption</label>
                <input type="date" name="dateperemption" id="dateperemption" required
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('dateperemption') }}">
                @error('dateperemption')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="lot">Lot</label>
                <input type="text" name="lot" id="lot" required pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" value="{{ old('lot') }}">
                @error('lot')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="user_id">Auteur</label><br>
                <input type="text" id="user_name" value="{{ auth()->user()->nom }}" disabled>
                <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                @error('user_id')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>


            <br>
            <button type="submit">Enregistrer</button>
        </form>

        <br>
        <a href="{{ route('produits.index') }}">← Retour à la liste des produits</a></br>
        <a href="{{ route('mouvements-produits.create') }}">→ Enregistrer un mouvement</a>
        </br>
    @endif {{-- ✅ Clôture du @if (!$canCreate) --}}

@endsection

{{-- @extends('layouts.app')

@section('title', 'Dashboard - Alertes')

@section('content')

@endsection --}}
