@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow rounded">
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
        <ul class="divide-y divide-gray-200">
            <li class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Nom :</span> 
                <span class="text-gray-900">{{ $user->nom }}</span>
            </li>
            <li class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Prénom :</span> 
                <span class="text-gray-900">{{ $user->prenom }}</span>
            </li>
            <li class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Adresse :</span> 
                <span class="text-gray-900">{{ $user->adresse }}</span>
            </li>
            <li class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Téléphone :</span> 
                <span class="text-gray-900">{{ $user->telephone }}</span>
            </li>
            <li class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Magasin affecté :</span> 
                <span class="text-gray-900">{{ ucfirst($user->magasin_affecte) }}</span>
            </li>
            <li class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Email :</span> 
                <span class="text-gray-900">{{ $user->email }}</span>
            </li>
        </ul>
        <a href="{{ route('users.index') }}" class="inline-block mt-6 px-4 py-2 bg-red-300 hover:bg-gray-700 text-white rounded transition duration-200">
            ← Retour à la liste
        </a>
        
    @endif
</div>
@endsection
