@extends('layouts.app')

@section('title', 'Accueil - CRTS Stock')

{{-- Page d'accueil en full-bleed : aucun padding ne doit venir du layout parent --}}
@section('main-class', 'p-0')

@section('content')
<div class="flex-1 flex flex-col w-full">

    {{-- ============ HERO ============ --}}
    <section class="w-full bg-gradient-to-br from-blue-950 via-blue-900 to-red-950 text-white">
        <div class="w-full max-w-6xl mx-auto px-6 md:px-10 py-16 md:py-24 flex flex-col items-center text-center">

            <img src="{{ asset('images/logo-crts.png') }}"
                 alt="Logo CRTS"
                 class="h-24 w-24 md:h-28 md:w-28 rounded-full shadow-xl border-4 border-white/90 bg-white p-2 mb-8" />

            <span class="uppercase tracking-widest text-xs md:text-sm text-red-300 font-semibold mb-3">
                Centre Régional de Transfusion Sanguine — Sokodé
            </span>

            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-5 max-w-3xl">
                <span id="typewriter"></span>
            </h1>

            <p class="text-base md:text-lg text-blue-200 max-w-2xl mb-10">
                La plateforme de référence pour la gestion, le suivi et la sécurisation
                des stocks de produits sanguins et d'articles de collation.
            </p>

            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-3 bg-red-600 hover:bg-red-700 text-white font-semibold
                      py-3.5 px-8 rounded-lg text-base shadow-lg transition-colors duration-200">
                <i class="fa-solid fa-right-to-bracket"></i>
                Accéder à l'application
            </a>
        </div>
    </section>

    {{-- ============ BANDEAU STATISTIQUES ============ --}}
    <section class="w-full bg-red-700 text-white">
        <div class="w-full max-w-6xl mx-auto px-6 md:px-10 py-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-2xl md:text-3xl font-bold">10K+</div>
                <div class="text-xs md:text-sm text-red-100 mt-1">Produits gérés</div>
            </div>
            <div>
                <div class="text-2xl md:text-3xl font-bold">500+</div>
                <div class="text-xs md:text-sm text-red-100 mt-1">Utilisateurs actifs</div>
            </div>
            <div>
                <div class="text-2xl md:text-3xl font-bold">99.9%</div>
                <div class="text-xs md:text-sm text-red-100 mt-1">Disponibilité</div>
            </div>
            <div>
                <div class="text-2xl md:text-3xl font-bold">24/7</div>
                <div class="text-xs md:text-sm text-red-100 mt-1">Support technique</div>
            </div>
        </div>
    </section>

    {{-- ============ FONCTIONNALITÉS ============ --}}
    <section class="w-full bg-gray-50">
        <div class="w-full max-w-6xl mx-auto px-6 md:px-10 py-16 md:py-20">

            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                    Pourquoi utiliser CRTS Stock ?
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto">
                    Une solution conçue pour les équipes médicales, simple à utiliser
                    et fiable au quotidien.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center mb-4">
                        <i class="fa-solid fa-shield-halved text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Sécurité optimale</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Gestion sécurisée des accès et traçabilité complète des mouvements de stock.
                    </p>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center mb-4">
                        <i class="fa-solid fa-chart-line text-amber-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Suivi en temps réel</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Monitoring continu des produits sanguins et alertes automatiques de rupture.
                    </p>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center mb-4">
                        <i class="fa-solid fa-users text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Interface intuitive</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Une ergonomie pensée pour votre équipe, sans courbe d'apprentissage.
                    </p>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.Typed) {
            new Typed('#typewriter', {
                strings: [
                    'Bienvenue sur CRTS Stock',
                    'Votre partenaire en gestion de stock',
                    "L'excellence au service de la santé"
                ],
                typeSpeed: 45,
                backSpeed: 25,
                backDelay: 2000,
                startDelay: 300,
                loop: true,
                showCursor: true,
                cursorChar: '|'
            });
        }
    });
</script>
@endpush
