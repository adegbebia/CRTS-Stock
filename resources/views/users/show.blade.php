@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Détails de l'utilisateur</h1>

    @php
        $userAuth = auth()->user();
    @endphp

    @if (!$userAuth->hasRole(['admin', 'magasinier_technique', 'magasinier_collation']))
        <p class="text-red-600 font-semibold mb-4">
            Accès refusé : vous n'êtes pas autorisé à voir ces informations.
        </p>
        <a href="{{ route('dashboard') }}" class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
            Retour
        </a>
    @else
        <div class="space-y-2">
            <p><strong>Nom :</strong> {{ $user->nom }}</p>
            <p><strong>Prénom :</strong> {{ $user->prenom }}</p>
            <p><strong>Adresse :</strong> {{ $user->adresse }}</p>
            <p><strong>Téléphone :</strong> {{ $user->telephone }}</p>
            <p><strong>Magasin affecté :</strong> {{ ucfirst($user->magasin_affecte) }}</p>
            <p><strong>Email :</strong> {{ $user->email }}</p>
        </div>

        <div class="mt-6 flex gap-3">
            @if ($userAuth->hasRole('admin'))
                <a href="{{ route('users.edit', $user->user_id) }}" class="bg-red-300 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Modifier
                </a>
            @endif

            <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                Retour à la liste
            </a>
        </div>
    @endif
</div>
@endsection
