@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Détails de l'Alerte Article</h1>

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Informations sur l'alerte</h2>

            <ul class="mb-6">
                <li><strong>ID de l'Alerte :</strong> {{ $alerte->alerteArt_id }}</li>
                <li><strong>Type d'alerte :</strong> {{ $alerte->typealerte }}</li>
                <li><strong>Date de déclenchement :</strong>
                    {{ $alerte->datedeclenchement ? $alerte->datedeclenchement->format('d/m/Y H:i') : 'Non définie' }}
                </li>
            </ul>

            @if ($alerte->article)
                <h2 class="text-xl font-semibold mb-4">Informations sur l'article lié</h2>
                <ul>
                    <li><strong>ID Article :</strong> {{ $alerte->article->article_id }}</li>
                    <li><strong>Libellé :</strong> {{ $alerte->article->libelle }}</li>
                    <li><strong>Conditionnement :</strong> {{ $alerte->article->conditionnement }}</li>
                    <li><strong>Stock actuel :</strong> {{ $alerte->article->quantitestock }}</li>
                    <li><strong>Stock de sécurité :</strong> {{ $alerte->article->stocksecurite }}</li>
                    <li><strong>Date de péremption :</strong> {{ $alerte->article->dateperemption }}</li>
                    <li><strong>Lot :</strong> {{ $alerte->article->lot }}</li>
                </ul>
            @else
                <div class="text-red-600 font-semibold">
                    ⚠️ Aucun article lié à cette alerte.
                </div>
            @endif
        </div>
    </div>
@endsection
