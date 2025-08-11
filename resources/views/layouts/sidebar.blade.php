<div id="sidebar" class="bg-base-200 w-64 p-6 shadow-lg transition-all duration-300 overflow-y-auto">
    <ul class="menu p-2 bg-base-100 text-base-content">
        {{-- Employés --}}
        <li><a href="{{ route('users.index') }}">Employés</a></li>

        <li><hr></li>

        {{-- Produits --}}
        <li><a href="{{ route('produits.index') }}">Produits</a></li>
        <li><a href="{{ route('consommations-produits.index') }}">Consommation produits</a></li>
        <li><a href="{{ route('mouvements-produits.index') }}">Mouvements produits</a></li>
        <li><a href="{{ route('alertes-produits.index') }}">Alertes produits</a></li>
        <li><a href="{{ route('rapports-produits.index') }}">Rapports produits</a></li>

        <li><hr></li>

        {{-- Articles --}}
        <li><a href="{{ route('articles.index') }}">Articles</a></li>
        <li><a href="{{ route('consommations-articles.index') }}">Consommation articles</a></li>
        <li><a href="{{ route('mouvements-articles.index') }}">Mouvements articles</a></li>
        <li><a href="{{ route('alertes-articles.index') }}">Alertes articles</a></li>
        <li><a href="{{ route('rapports-articles.index') }}">Rapports articles</a></li>

        <li><hr></li>
    </ul>
</div>
