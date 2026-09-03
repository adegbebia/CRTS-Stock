@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
    <div class="flex items-center mb-8 pb-4 border-b-2 border-red-600">
        <i class="fa-solid fa-user-circle text-red-600 text-3xl mr-3"></i>
        <h1 class="text-3xl font-bold text-gray-900">Détails de l'utilisateur</h1>
    </div>

    @php
        $userAuth = auth()->user();
    @endphp

    @if (!$userAuth->hasRole(['admin', 'magasinier_technique', 'magasinier_collation']))
        <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-r-lg mb-6">
            <div class="flex items-start">
                <i class="fa-solid fa-circle-exclamation text-red-600 text-2xl mr-3 mt-1"></i>
                <div>
                    <p class="text-red-800 font-semibold text-lg">Accès refusé</p>
                    <p class="text-red-700 mt-1">Vous n'êtes pas autorisé à voir ces informations.</p>
                    <a href="{{ route('dashboard') }}" 
                       class="mt-4 inline-flex items-center text-red-600 hover:text-red-800 font-medium hover:underline">
                        <i class="fa-solid fa-arrow-left mr-1"></i>
                        Retour au tableau de bord
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700 flex items-center">
                        <i class="fa-solid fa-user text-red-500 mr-2"></i>
                        Nom
                    </span> 
                    <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $user->nom }}</span>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700 flex items-center">
                        <i class="fa-solid fa-id-badge text-purple-600 mr-2"></i>
                        Nom Pseudo
                    </span> 
                    <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $user->nom_pseudo }}</span>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700 flex items-center">
                        <i class="fa-solid fa-user-tag text-blue-600 mr-2"></i>
                        Prénom
                    </span> 
                    <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $user->prenom }}</span>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700 flex items-center">
                        <i class="fa-solid fa-location-dot text-green-600 mr-2"></i>
                        Adresse
                    </span> 
                    <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $user->adresse }}</span>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700 flex items-center">
                        <i class="fa-solid fa-phone text-blue-600 mr-2"></i>
                        Téléphone
                    </span> 
                    <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $user->telephone }}</span>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700 flex items-center">
                        <i class="fa-solid fa-building text-indigo-600 mr-2"></i>
                        Magasin affecté
                    </span> 
                    <span class="mt-2 sm:mt-0">
                        <span class="px-3 py-1 inline-flex text-sm font-medium rounded-full 
                            @if($user->magasin_affecte === 'admin') bg-blue-100 text-blue-800
                            @elseif($user->magasin_affecte === 'technique') bg-red-100 text-red-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($user->magasin_affecte) }}
                        </span>
                    </span>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3">
                    <span class="font-medium text-gray-700 flex items-center">
                        <i class="fa-solid fa-envelope text-yellow-500 mr-2"></i>
                        Email
                    </span> 
                    <span class="text-gray-900 font-semibold mt-2 sm:mt-0 break-words">{{ $user->email }}</span>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end">
            <a href="{{ route('users.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
        </div>
    @endif
</div>
@endsection