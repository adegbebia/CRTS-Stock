@php
    use App\Models\AlerteProduit;
    use App\Models\AlerteArticle;

    $alertesProduits = AlerteProduit::with('produit')->get();
    $alertesArticles = AlerteArticle::with('article')->get();

    $nbAlertes = $alertesProduits->count() + $alertesArticles->count();
    $user = auth()->user();
@endphp

<header class="bg-white border-b shadow-sm sticky top-0 z-40">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- Logo --}}
            <div class="flex-shrink-0 text-xl font-bold text-indigo-600 select-none">
                🧮 MonApplication
            </div>

            {{-- Section droite --}}
            <div class="relative md:flex items-center space-x-6">

                {{-- Notifications dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                        class="relative text-gray-600 hover:text-red-600 transition text-xl focus:outline-none" 
                        aria-label="Notifications">
                        🔔
                        @if($nbAlertes > 0)
                            <span class="absolute -top-1.5 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5">
                                {{ $nbAlertes }}
                            </span>
                        @endif
                    </button>

                    {{-- Dropdown menu --}}
                    <div x-show="open" 
                         @click.away="open = false" 
                         x-transition
                         class="origin-top-right absolute right-0 mt-2 w-96 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                         style="display: none;">
                        <div class="py-2 max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-indigo-400 scrollbar-track-indigo-100">

                            {{-- ✅ Produits : Admin + Magasinier Technique --}}
                            @if($alertesProduits->isNotEmpty() && ($user->hasRole('admin') || $user->hasRole('magasinier_technique')))
                                <div class="px-4 py-2 text-xs uppercase text-indigo-500 font-bold bg-gray-100 sticky top-0">Produits</div>
                                @foreach($alertesProduits->sortByDesc('datedeclenchement') as $alerte)
                                    <a href="{{ route('alertes-produits.show', $alerte->alerteProd_id) }}" 
                                       class="block px-4 py-2 hover:bg-indigo-50 border-b border-gray-200 text-sm text-gray-700 truncate">
                                        <span class="flex items-center gap-1">
                                            📦 <strong>{{ $alerte->produit->libelle ?? 'Produit supprimé' }}</strong>
                                        </span>
                                        <span class="block mt-1">
                                            @include('components.badge-type-alerte', ['type' => $alerte->typealerte])
                                        </span>
                                        <small class="text-gray-400">Déclenché le {{ $alerte->datedeclenchement->format('d/m/Y H:i') }}</small>
                                    </a>
                                @endforeach
                            @endif

                            {{-- ✅ Articles : Admin + Magasinier Collation --}}
                            @if($alertesArticles->isNotEmpty() && ($user->hasRole('admin') || $user->hasRole('magasinier_collation')))
                                <div class="px-4 py-2 text-xs uppercase text-green-500 font-bold bg-gray-100 sticky top-0">Articles</div>
                                @foreach($alertesArticles->sortByDesc('datedeclenchement') as $alerte)
                                    <a href="{{ route('alertes-articles.show', $alerte->alerteArt_id) }}" 
                                       class="block px-4 py-2 hover:bg-green-50 border-b border-gray-200 text-sm text-gray-700 truncate">
                                        <span class="flex items-center gap-1">
                                            🧾 <strong>{{ $alerte->article->libelle ?? 'Article supprimé' }}</strong>
                                        </span>
                                        <span class="block mt-1">
                                            @include('components.badge-type-alerte', ['type' => $alerte->typealerte])
                                        </span>
                                        <small class="text-gray-400">Déclenché le {{ $alerte->datedeclenchement->format('d/m/Y H:i') }}</small>
                                    </a>
                                @endforeach
                            @endif

                            {{-- 🔕 Aucune alerte visible --}}
                            @if(
                                ($alertesProduits->isEmpty() && $alertesArticles->isEmpty()) || 
                                (!$user->hasRole('admin') && !$user->hasRole('magasinier_technique') && !$user->hasRole('magasinier_collation'))
                            )
                                <div class="px-4 py-3 text-gray-500 text-center select-none">
                                    Pas de notifications
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                {{-- Utilisateur connecté --}}
                <div class="text-gray-700 font-semibold flex items-center space-x-2 select-none">
                    <span>👤 {{ auth()->user()->nom ?? 'Utilisateur' }}</span>
                </div>

                {{-- Bouton déconnexion --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="text-red-600 hover:underline font-semibold focus:outline-none focus:ring-2 focus:ring-red-400 rounded">
                        Se déconnecter
                    </button>
                </form>
            </div>

        </div>
    </div>
</header>

<script src="//unpkg.com/alpinejs" defer></script>
