@extends('layouts.app')



@section('content')

    <h1>Détails de l'utilisateur</h1>

    @php
        $userAuth = auth()->user();
    @endphp

    @if (!$userAuth->hasRole(['admin', 'magasinier_technique', 'magasinier_collation']))
        <p style="color: red;">Accès refusé : vous n'êtes pas autorisé à voir ces informations.</p>
        <a href="{{ route('dashboard') }}">Retour</a>
    @else
        <p><strong>Nom :</strong> {{ $user->nom }}</p>
        <p><strong>Prénom :</strong> {{ $user->prenom }}</p>
        <p><strong>Adresse :</strong> {{ $user->adresse }}</p>
        <p><strong>Téléphone :</strong> {{ $user->telephone }}</p>
        <p><strong>Magasin affecté :</strong> {{ ucfirst($user->magasin_affecte) }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>

        @if ($userAuth->hasRole('admin'))
            <a href="{{ route('users.edit', $user->user_id) }}">Modifier</a>
        @endif

        <a href="{{ route('users.index') }}">Retour à la liste</a>
    @endif

@endsection
