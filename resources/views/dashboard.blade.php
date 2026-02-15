@extends('layouts.app')

@section('title', 'Dashboard - Alertes')

@section('content')
<div id="dashboardContent" class="transition-all duration-300 ml-0 md:ml-64 p-4 md:p-6 bg-gray-50 min-h-screen">
    <!-- Carte de bienvenue -->
    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-xl md:rounded-2xl shadow-xl p-4 md:p-6 mb-6 md:mb-8 text-white">
        <div class="flex flex-col md:flex-row items-center">
            <div class="bg-white/20 p-3 md:p-4 rounded-full mb-4 md:mb-0 md:mr-4">
                <i class="fa-solid fa-user text-2xl md:text-3xl"></i>
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold tracking-tight">Bonjour, {{ auth()->user()->prenom }} {{ auth()->user()->nom }} !</h1>
                <p class="text-red-100 mt-1 text-sm md:text-base">Centre Régional de Transfusion Sanguine - Système de Gestion de Stock</p>
            </div>
        </div>
    </div>

    {{-- SweetAlert message de succès --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc2626'
            });
        </script>
    @endif

    {{-- Alertes Produits --}}
    @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('magasinier_technique'))
        <section class="mb-8 md:mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 md:mb-5 pb-3 border-b-2 border-red-600">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center mb-3 md:mb-0">
                    <i class="fa-solid fa-boxes-stacked text-red-600 mr-2 md:mr-3 text-xl md:text-2xl"></i>
                    Alertes Produits
                </h2>
                <span class="px-2.5 py-1 md:px-3 md:py-1 bg-red-100 text-red-800 rounded-full font-medium text-xs md:text-sm self-start md:self-auto">
                    {{ $alertesProduits->count() }} alerte{{ $alertesProduits->count() > 1 ? 's' : '' }}
                </span>
            </div>
            
            @if ($alertesProduits->count())
                <div class="space-y-3">
                    @foreach ($alertesProduits as $alerte)
                        <div class="border-l-4 rounded-r-lg md:rounded-r-xl bg-white shadow-sm md:shadow-md p-3 md:p-4 hover:shadow-md md:hover:shadow-lg transition-all duration-200
                                    @switch($alerte->typealerte)
                                        @case('Alerte rouge') border-red-500 @break
                                        @case('Alerte orange') border-orange-500 @break
                                        @case('Rupture de stock') border-yellow-500 @break
                                        @case('Alerte verte') border-green-500 @break
                                        @default border-gray-500
                                    @endswitch">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                                <div class="flex-1">
                                    <div class="flex flex-col md:flex-row">
                                        <div class="bg-red-100 p-2 rounded-lg mb-3 md:mb-0 md:mr-3 flex-shrink-0">
                                            <i class="fa-solid fa-vial text-red-600 text-lg md:text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 text-base md:text-lg">
                                                {{ $alerte->produit->libelle ?? 'Produit supprimé' }}
                                            </p>
                                            <p class="text-gray-600 mt-1 flex items-center text-xs md:text-sm">
                                                <i class="fa-solid fa-clock text-gray-400 mr-1.5 md:mr-2 text-xs"></i>
                                                <span>{{ \Carbon\Carbon::parse($alerte->datedeclenchement)->translatedFormat('d F Y à H:i') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 md:mt-0 md:ml-4 lg:ml-6 flex-shrink-0">
                                    @switch($alerte->typealerte)
                                        @case('Alerte rouge')
                                            <span class="px-3 py-1.5 md:px-4 md:py-2 bg-red-100 text-red-800 rounded-full font-bold text-xs md:text-sm flex items-center">
                                                <i class="fa-solid fa-triangle-exclamation mr-1.5 md:mr-2 text-xs"></i>
                                                <span class="hidden xs:inline">Stock critique</span>
                                            </span>
                                        @break
                                        @case('Alerte orange')
                                            <span class="px-3 py-1.5 md:px-4 md:py-2 bg-orange-100 text-orange-800 rounded-full font-bold text-xs md:text-sm flex items-center">
                                                <i class="fa-solid fa-circle-exclamation mr-1.5 md:mr-2 text-xs"></i>
                                                <span class="hidden xs:inline">Stock faible</span>
                                            </span>
                                        @break
                                        @case('Rupture de stock')
                                            <span class="px-3 py-1.5 md:px-4 md:py-2 bg-yellow-100 text-yellow-800 rounded-full font-bold text-xs md:text-sm flex items-center">
                                                <i class="fa-solid fa-bolt mr-1.5 md:mr-2 text-xs"></i>
                                                <span class="hidden xs:inline">Rupture imminente</span>
                                            </span>
                                        @break
                                        @case('Alerte verte')
                                            <span class="px-3 py-1.5 md:px-4 md:py-2 bg-green-100 text-green-800 rounded-full font-bold text-xs md:text-sm flex items-center">
                                                <i class="fa-solid fa-check-circle mr-1.5 md:mr-2 text-xs"></i>
                                                <span class="hidden xs:inline">Stock acceptable</span>
                                            </span>
                                        @break
                                        @default
                                            <span class="px-3 py-1.5 md:px-4 md:py-2 bg-gray-100 text-gray-800 rounded-full font-bold text-xs md:text-sm flex items-center">
                                                <i class="fa-solid fa-calendar-xmark mr-1.5 md:mr-2 text-xs"></i>
                                                <span class="hidden xs:inline">Périmé</span>
                                            </span>
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg md:rounded-xl border-2 border-dashed border-gray-300 p-6 md:p-12 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-full bg-green-100 text-green-600 mb-3 md:mb-4">
                        <i class="fa-solid fa-check-circle text-2xl md:text-3xl"></i>
                    </div>
                    <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-2">Tous les stocks sont en bonne santé !</h3>
                    <p class="text-gray-500 text-xs md:text-sm max-w-md mx-auto">Aucune alerte produit à signaler pour le moment. Félicitations pour votre gestion proactive.</p>
                </div>
            @endif
        </section>
    @endif

    {{-- Alertes Articles --}}
    @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('magasinier_collation'))
        <section>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 md:mb-5 pb-3 border-b-2 border-red-600">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center mb-3 md:mb-0">
                    <i class="fa-solid fa-utensils text-red-600 mr-2 md:mr-3 text-xl md:text-2xl"></i>
                    Alertes Articles
                </h2>
                <span class="px-2.5 py-1 md:px-3 md:py-1 bg-red-100 text-red-800 rounded-full font-medium text-xs md:text-sm self-start md:self-auto">
                    {{ $alertesArticles->count() }} alerte{{ $alertesArticles->count() > 1 ? 's' : '' }}
                </span>
            </div>
            
            @if ($alertesArticles->count())
                <div class="space-y-3">
                    @foreach ($alertesArticles as $alerte)
                        <div class="border-l-4 rounded-r-lg md:rounded-r-xl bg-white shadow-sm md:shadow-md p-3 md:p-4 hover:shadow-md md:hover:shadow-lg transition-all duration-200
                                    @switch($alerte->typealerte)
                                        @case('Alerte rouge') border-red-500 @break
                                        @case('Alerte orange') border-orange-500 @break
                                        @case('Rupture de stock') border-yellow-500 @break
                                        @case('Alerte verte') border-green-500 @break
                                        @default border-gray-500
                                    @endswitch">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                                <div class="flex-1">
                                    <div class="flex flex-col md:flex-row">
                                        <div class="bg-red-100 p-2 rounded-lg mb-3 md:mb-0 md:mr-3 flex-shrink-0">
                                            <i class="fa-solid fa-bowl-food text-red-600 text-lg md:text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 text-base md:text-lg">
                                                {{ $alerte->article->libelle ?? 'Article supprimé' }}
                                            </p>
                                            <p class="text-gray-600 mt-1 flex items-center text-xs md:text-sm">
                                                <i class="fa-solid fa-clock text-gray-400 mr-1.5 md:mr-2 text-xs"></i>
                                                <span>{{ \Carbon\Carbon::parse($alerte->datedeclenchement)->translatedFormat('d F Y à H:i') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 md:mt-0 md:ml-4 lg:ml-6 flex-shrink-0">
                                    @switch($alerte->typealerte)
                                        @case('Alerte rouge')
                                            <span class="px-3 py-1.5 md:px-4 md:py-2 bg-red-100 text-red-800 rounded-full font-bold text-xs md:text-sm flex items-center">
                                                <i class="fa-solid fa-triangle-exclamation mr-1.5 md:mr-2 text-xs"></i>
                                                <span class="hidden xs:inline">Stock critique</span>
                                            </span>
                                        @break
                                        @case('Alerte orange')
                                            <span class="px-3 py-1.5 md:px-4 md:py-2 bg-orange-100 text-orange-800 rounded-full font-bold text-xs md:text-sm flex items-center">
                                                <i class="fa-solid fa-circle-exclamation mr-1.5 md:mr-2 text-xs"></i>
                                                <span class="hidden xs:inline">Stock faible</span>
                                            </span>
                                        @break
                                        @case('Rupture de stock')
                                            <span class="px-3 py-1.5 md:px-4 md:py-2 bg-yellow-100 text-yellow-800 rounded-full font-bold text-xs md:text-sm flex items-center">
                                                <i class="fa-solid fa-bolt mr-1.5 md:mr-2 text-xs"></i>
                                                <span class="hidden xs:inline">Rupture imminente</span>
                                            </span>
                                        @break
                                        @case('Alerte verte')
                                            <span class="px-3 py-1.5 md:px-4 md:py-2 bg-green-100 text-green-800 rounded-full font-bold text-xs md:text-sm flex items-center">
                                                <i class="fa-solid fa-check-circle mr-1.5 md:mr-2 text-xs"></i>
                                                <span class="hidden xs:inline">Stock acceptable</span>
                                            </span>
                                        @break
                                        @default
                                            <span class="px-3 py-1.5 md:px-4 md:py-2 bg-gray-100 text-gray-800 rounded-full font-bold text-xs md:text-sm flex items-center">
                                                <i class="fa-solid fa-calendar-xmark mr-1.5 md:mr-2 text-xs"></i>
                                                <span class="hidden xs:inline">Périmé</span>
                                            </span>
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg md:rounded-xl border-2 border-dashed border-gray-300 p-6 md:p-12 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-full bg-green-100 text-green-600 mb-3 md:mb-4">
                        <i class="fa-solid fa-check-circle text-2xl md:text-3xl"></i>
                    </div>
                    <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-2">Tous les stocks sont en bonne santé !</h3>
                    <p class="text-gray-500 text-xs md:text-sm max-w-md mx-auto">Aucune alerte article à signaler pour le moment. Félicitations pour votre gestion proactive.</p>
                </div>
            @endif
        </section>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('dashboardContent');
            
            if (toggleBtn && sidebar && content) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                    
                    if (window.innerWidth >= 768) { // md breakpoint
                        if (sidebar.classList.contains('-translate-x-full')) {
                            content.classList.remove('md:ml-64');
                            content.classList.add('md:ml-0');
                        } else {
                            content.classList.remove('md:ml-0');
                            content.classList.add('md:ml-64');
                        }
                    }
                });
            }
        });
    </script>
@endpush
@endsection