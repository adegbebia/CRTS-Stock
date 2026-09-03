<footer class="footer footer-horizontal footer-center bg-red-900 border-t border-red-800 text-white p-8 shadow-lg">
    
    <!-- Section principale -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl mx-auto">
        
        <!-- Colonne 1 : Logo + Mission -->
        <div class="text-center md:text-left">
            <div class="flex justify-center md:justify-start mb-4">
                <img src="{{ asset('images/logo-crts.png') }}" 
                     alt="Logo CRTS" 
                     class="h-16 w-16 rounded-full border-2 border-red-700 bg-white p-1" />
            </div>
            <p class="text-sm text-red-200">
                Centre Régional de Transfusion Sanguine<br>
                <span class="font-semibold text-white">Sauver des vies, gérer avec excellence</span>
            </p>
        </div>
        
        <!-- Colonne 2 : Liens rapides -->
        <div class="text-center">
            <h3 class="text-lg font-bold text-red-300 mb-4">Liens utiles</h3>
            <nav class="space-y-2">
                <a href="#" class="link link-hover hover:text-red-300 transition">Tableau de bord</a>
                <a href="#" class="link link-hover hover:text-red-300 transition">Gestion des stocks</a>
                <a href="#" class="link link-hover hover:text-red-300 transition">Alertes produits</a>
                <a href="#" class="link link-hover hover:text-red-300 transition">Rapports</a>
            </nav>
        </div>
        
        <!-- Colonne 3 : Contact institutionnel -->
        <div class="text-center md:text-right">
            <h3 class="text-lg font-bold text-red-300 mb-4">Contact institutionnel</h3>
            <div class="space-y-2 text-sm text-red-200">
                <div class="flex items-start justify-center md:justify-end">
                    <i class="fa-solid fa-envelope mt-1 mr-2 text-red-400"></i>
                    <span>crtssokode2020@gmail.com</span>
                </div>
                <div class="flex items-start justify-center md:justify-end">
                    <i class="fa-solid fa-phone mt-1 mr-2 text-red-400"></i>
                    <span>+228 92 21 49 21 (Standard)</span>
                </div>
                <div class="flex items-start justify-center md:justify-end">
                    <i class="fa-solid fa-location-dot mt-1 mr-2 text-red-400"></i>
                    <span>Route Nationale N°2, Sokodé<br>Région Centrale, Togo</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Barre de séparation -->
    <div class="w-full max-w-6xl mx-auto my-6 border-t border-red-800"></div>
    
    <!-- Bas de page légal -->
    <aside class="text-center w-full max-w-6xl mx-auto text-sm text-red-200">
        <p>
            © <span id="current-year"></span> CRTS Sokodé - 
            <span class="hidden md:inline">Application de gestion des stocks (Technique & Collation) - </span>
            Version {{ config('app.version', '1.0.0') }} |
            <a href="#" id="about-link" class="hover:text-red-300 transition ml-2">Mentions légales</a>
        </p>
        <p class="mt-2 text-xs italic">
            Application développée dans le cadre du projet académique 4IFNTI Sokodé - L2/S4 2025
        </p>
    </aside>
    
    <!-- Mentions légales (caché par défaut) -->
    <div id="about-text" class="mx-auto mt-6 max-w-4xl p-6 bg-red-800/90 text-white rounded-lg shadow-lg hidden">
        <h3 class="text-2xl font-bold text-red-300 mb-4 text-center">Mentions légales</h3>
        
        <div class="space-y-4 text-justify">
            <div>
                <h4 class="font-bold text-lg text-red-200 mb-2">Éditeur</h4>
                <p>Centre Régional de Transfusion Sanguine (CRTS) de Sokodé<br>
                Route Nationale N°2, Sokodé, Région Centrale, Togo<br>
                Téléphone : +228 92 21 49 21 / 70 45 66 80</p>
            </div>
            
            <div>
                <h4 class="font-bold text-lg text-red-200 mb-2">Développement</h4>
                <p>Ce logiciel a été développé dans le cadre d'un projet académique par des étudiants de la filière Informatique  de l'Université (IFNTI) de Sokodé - Promotion L2/S4 2025.</p>
            </div>
            
            <div>
                <h4 class="font-bold text-lg text-red-200 mb-2">Propriété intellectuelle</h4>
                <p>L'ensemble des contenus de cette application (textes, images, logos, structure) sont la propriété exclusive du CRTS Sokodé. Toute reproduction ou utilisation non autorisée est strictement interdite.</p>
            </div>
            
            <div>
                <h4 class="font-bold text-lg text-red-200 mb-2">Protection des données</h4>
                <p>Cette application respecte le Règlement Général sur la Protection des Données (RGPD). Les données personnelles collectées sont strictement nécessaires à la gestion des stocks et ne sont pas transmises à des tiers.</p>
            </div>
        </div>
        
        <div class="mt-6 text-center">
            <button id="close-about" class="btn bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                Fermer
            </button>
        </div>
    </div>

</footer>

<script>
    // Année dynamique
    document.getElementById('current-year').textContent = new Date().getFullYear();
    
    // Toggle Mentions légales
    document.getElementById('about-link').addEventListener('click', function(e) {
        e.preventDefault();
        const aboutText = document.getElementById('about-text');
        aboutText.classList.toggle('hidden');
        if (!aboutText.classList.contains('hidden')) {
            aboutText.scrollIntoView({ behavior: 'smooth' });
        }
    });
    
    // Bouton Fermer
    document.getElementById('close-about')?.addEventListener('click', function() {
        document.getElementById('about-text').classList.add('hidden');
    });
</script>