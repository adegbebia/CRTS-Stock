@extends('layouts.app')

@section('title', 'Accueil - CRTS Stock')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-950 via-blue-900 to-blue-950 relative overflow-hidden">
    <!-- Particules animées en arrière-plan -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-64 h-64 bg-red-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow-reverse"></div>
        <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-white/5 rounded-full blur-2xl"></div>
    </div>

    <!-- Contenu principal -->
    <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
        <div class="text-center text-white max-w-4xl mx-auto px-4">
            <!-- Logo animé -->
            <div class="relative inline-block mb-12 group">
                <div class="absolute inset-0 bg-gradient-to-r from-red-500 to-red-700 rounded-full blur-xl opacity-30 animate-pulse-slow"></div>
                <img src="{{ asset('images/logo-crts.png') }}" 
                     alt="Logo CRTS" 
                     class="mx-auto h-40 w-40 rounded-full shadow-2xl border-4 border-red-600 bg-white p-3 transform transition-all duration-500 group-hover:scale-110 group-hover:rotate-6" />
                <div class="absolute inset-0 rounded-full border-2 border-red-600/30 animate-ping"></div>
            </div>

            <!-- Titre avec animation typewriter -->
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-red-400 to-red-600 animate-fade-in">
                <span id="typewriter" class="inline-block min-h-[2.5rem] md:min-h-[3.5rem]"></span>
            </h1>
            
            <!-- Sous-titre -->
            <p class="text-xl md:text-2xl text-blue-200 mb-12 animate-fade-in-delay-1">
                Système de Gestion de Stock du Centre Régional de Transfusion Sanguine
            </p>

            <!-- Features avec animation au scroll -->
            <div class="space-y-6 mb-16 max-w-2xl mx-auto">
                <div class="feature-item flex items-start space-x-4 p-4 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 hover:border-red-500/50 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fa-solid fa-shield-check text-green-400 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white mb-1">Sécurité Optimale</h3>
                        <p class="text-blue-200">Gestion sécurisée et optimisée de votre stock</p>
                    </div>
                </div>

                <div class="feature-item flex items-start space-x-4 p-4 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 hover:border-red-500/50 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fa-solid fa-chart-line text-yellow-400 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white mb-1">Suivi en Temps Réel</h3>
                        <p class="text-blue-200">Monitoring continu des produits sanguins</p>
                    </div>
                </div>

                <div class="feature-item flex items-start space-x-4 p-4 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 hover:border-red-500/50 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fa-solid fa-users text-blue-400 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white mb-1">Interface Intuitive</h3>
                        <p class="text-blue-200">Ergonomie pensée pour votre équipe médicale</p>
                    </div>
                </div>
            </div>

            <!-- Bouton de connexion -->
            <div class="mt-8 animate-fade-in-delay-2">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold 
                          py-4 px-10 rounded-xl text-lg shadow-2xl transition-all duration-300 
                          transform hover:scale-105 hover:shadow-red-500/50 group relative overflow-hidden">
                    <span class="absolute inset-0 bg-gradient-to-r from-red-500 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                    <i class="fa-solid fa-right-to-bracket mr-3 text-xl group-hover:mr-4 transition-all"></i>
                    <span class="relative z-10">Accéder à l'Application</span>
                    <i class="fa-solid fa-arrow-right ml-2 opacity-0 group-hover:opacity-100 transform group-hover:translate-x-2 transition-all"></i>
                </a>
            </div>

            <!-- Statistiques -->
            <div class="mt-16 pt-8 border-t border-white/10 animate-fade-in-delay-3">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div class="stat-item">
                        <div class="text-3xl md:text-4xl font-bold text-red-400">10K+</div>
                        <div class="text-sm text-blue-200 mt-1">Produits Gérés</div>
                    </div>
                    <div class="stat-item">
                        <div class="text-3xl md:text-4xl font-bold text-red-400">500+</div>
                        <div class="text-sm text-blue-200 mt-1">Utilisateurs Actifs</div>
                    </div>
                    <div class="stat-item">
                        <div class="text-3xl md:text-4xl font-bold text-red-400">99.9%</div>
                        <div class="text-sm text-blue-200 mt-1">Disponibilité</div>
                    </div>
                    <div class="stat-item">
                        <div class="text-3xl md:text-4xl font-bold text-red-400">24/7</div>
                        <div class="text-sm text-blue-200 mt-1">Support Technique</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulseSlow {
        0%, 100% { transform: scale(1); opacity: 0.3; }
        50% { transform: scale(1.2); opacity: 0.5; }
    }
    @keyframes pulseSlowReverse {
        0%, 100% { transform: scale(1); opacity: 0.2; }
        50% { transform: scale(0.8); opacity: 0.4; }
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDelay1 {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDelay2 {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDelay3 {
        from { opacity: 0; transform: translateY(50px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .animate-pulse-slow {
        animation: pulseSlow 8s ease-in-out infinite;
    }
    .animate-pulse-slow-reverse {
        animation: pulseSlowReverse 10s ease-in-out infinite;
    }
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
    .animate-fade-in-delay-1 {
        animation: fadeInDelay1 0.8s ease-out 0.2s forwards;
    }
    .animate-fade-in-delay-2 {
        animation: fadeInDelay2 0.8s ease-out 0.4s forwards;
    }
    .animate-fade-in-delay-3 {
        animation: fadeInDelay3 0.8s ease-out 0.6s forwards;
    }
    .feature-item {
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }
    .feature-item:nth-child(1) { animation-delay: 0.3s; opacity: 0; }
    .feature-item:nth-child(2) { animation-delay: 0.5s; opacity: 0; }
    .feature-item:nth-child(3) { animation-delay: 0.7s; opacity: 0; }
    .stat-item {
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }
    .stat-item:nth-child(1) { animation-delay: 0.8s; opacity: 0; }
    .stat-item:nth-child(2) { animation-delay: 0.9s; opacity: 0; }
    .stat-item:nth-child(3) { animation-delay: 1.0s; opacity: 0; }
    .stat-item:nth-child(4) { animation-delay: 1.1s; opacity: 0; }
</style>

<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation typewriter pour le titre
        new Typed('#typewriter', {
            strings: [
                'Bienvenue sur <span class="text-red-500">CRTS Stock</span>',
                'Votre partenaire en <span class="text-red-500">gestion de stock</span>',
                'L\'excellence au <span class="text-red-500">service de la santé</span>'
            ],
            typeSpeed: 50,
            backSpeed: 30,
            backDelay: 2000,
            startDelay: 500,
            loop: true,
            showCursor: true,
            cursorChar: '|',
            smartBackspace: true,
            shuffle: false
        });

        // Animation au scroll pour les features
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-item, .stat-item').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            observer.observe(item);
        });

        // Effet de flottement sur le logo
        const logo = document.querySelector('img[alt="Logo CRTS"]');
        if (logo) {
            logo.style.animation = 'float 3s ease-in-out infinite';
        }
    });
</script>
@endsection