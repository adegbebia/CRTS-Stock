@extends('layouts.app')



@section('content')

    @php
        $user = auth()->user();
        $canCreate = $user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation';
    @endphp

    @if (!$canCreate)
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Accès refusé',
                text: 'Vous n\'avez pas la permission de créer un article.',
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then(() => {
                window.location.href = "{{ route('articles.index') }}";
            });
        </script>
    @else
        <h2>Ajouter / Créer un nouvel article</h2>

        <!-- Affichage des erreurs de validation -->
        <!-- @if ($errors->any())
    <div style="color:red;">
                    <ul>
                        @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
                    </ul>
                </div>
    @endif -->

        <!-- Formulaire -->
        <form action="{{ route('articles.store') }}" method="POST">
            @csrf

            <div>
                <label for="codearticle">Code Article</label>
                <input type="text" name="codearticle" id="codearticle" required pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" value="{{ old('codearticle') }}"><br>
                @error('codearticle')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="libelle">Libellé</label>
                <input type="text" name="libelle" id="libelle" required pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" value="{{ old('libelle') }}"><br>
                @error('libelle')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="conditionnement">Conditionnement</label>
                <input type="text" name="conditionnement" id="conditionnement" required pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" value="{{ old('conditionnement') }}"><br>
                @error('conditionnement')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="quantitestock">Quantité</label>
                <input type="number" name="quantitestock" id="quantitestock" min="0" required
                    value="{{ old('quantitestock') }}"><br>
                @error('quantitestock')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="stockmax">Stock maximum</label>
                <input type="number" name="stockmax" id="stockmax" min="0" required
                    value="{{ old('stockmax') }}"><br>
                @error('stockmax')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="stockmin">Stock minimum</label>
                <input type="number" name="stockmin" id="stockmin" min="0" required
                    value="{{ old('stockmin') }}"><br>
                @error('stockmin')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="stocksecurite">Stock de sécurité</label>
                <input type="number" name="stocksecurite" id="stocksecurite" min="0" required
                    value="{{ old('stocksecurite') }}"><br>
                @error('stocksecurite')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="dateperemption">Date de péremption</label>
                <input type="date" name="dateperemption" id="dateperemption" required
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('dateperemption') }}"><br>
                @error('dateperemption')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="lot">Lot</label>
                <input type="text" name="lot" id="lot" required pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" value="{{ old('lot') }}"><br>
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
        <br>
        <a href="{{ route('articles.index') }}">← Retour à la liste des articles</a><br>
        <a href="{{ route('mouvements-articles.create') }}">→ Enregistrer un mouvement</a>
        </br>
    @endif

@endsection
