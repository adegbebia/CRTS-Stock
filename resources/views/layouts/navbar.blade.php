@php
$user = auth()->user();

// Initiales Google-style
$fullName = trim($user->nom . ' ' . $user->prenom);
$initiales = collect(explode(' ', $fullName))
    ->map(fn($n) => strtoupper(substr($n, 0, 1)))
    ->join('');

// Préparer alertes
$alertesProduits = collect();
$alertesArticles = collect();
$nbAlertes = 0;

if ($user->hasRole('admin')) {
    $alertesProduits = App\Models\AlerteProduit::with('produit')->get();
    $alertesArticles = App\Models\AlerteArticle::with('article')->get();
    $nbAlertes = $alertesProduits->count() + $alertesArticles->count();
} elseif ($user->hasRole('magasinier_technique')) {
    $alertesProduits = App\Models\AlerteProduit::with('produit')->get();
    $nbAlertes = $alertesProduits->count();
} elseif ($user->hasRole('magasinier_collation')) {
    $alertesArticles = App\Models\AlerteArticle::with('article')->get();
    $nbAlertes = $alertesArticles->count();
}
@endphp

<div class="navbar bg-red-200 text-gray-800 shadow-sm border-1 border-blue-400">

    
    <div class="navbar-start">
        <a href="#" id="toggleSidebar" class="btn btn-ghost text-xl">☰</a>

    </div>

    
    <div class="navbar-center">
        <a class="btn btn-ghost text-3xl">CRTS-STOCK</a>
    </div>

    
    <div class="navbar-end flex items-center space-x-4">

       
        <div x-data="{ openNotif: false }" class="relative">
            <button @click.stop="openNotif = !openNotif" class="btn btn-ghost btn-circle relative">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11
                                 a6.002 6.002 0 00-4-5.659V5
                                 a2 2 0 10-4 0v.341
                                 C7.67 6.165 6 8.388 6 11v3.159
                                 c0 .538-.214 1.055-.595 1.436L4 17h5
                                 m6 0v1a3 3 0 11-6 0v-1
                                 m6 0H9" />
                    </svg>

                    @if($nbAlertes > 0)
                        <span class="badge badge-xs bg-red-600 text-white absolute -top-1.5 -right-2">
                            {{ $nbAlertes }}
                        </span>
                    @endif
                </div>
            </button>

            <div x-show="openNotif" x-transition @click.away="openNotif = false" x-cloak
                 class="origin-top-right absolute right-0 mt-2 w-96 bg-white shadow-lg rounded-md z-50">
                <div class="py-2 max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-indigo-400 scrollbar-track-indigo-100">

                    {{-- Produits --}}
                    @if($alertesProduits->isNotEmpty() && ($user->hasRole('admin') || $user->hasRole('magasinier_technique')))
                        <div class="px-4 py-2 text-xs uppercase text-indigo-500 font-bold bg-gray-100 sticky top-0">
                            Produits
                        </div>
                        @foreach($alertesProduits->sortByDesc('datedeclenchement') as $alerte)
                            <a href="{{ route('alertes-produits.show', $alerte->alerteProd_id) }}"
                               class="block px-4 py-2 hover:bg-indigo-50 border-b border-gray-200 text-sm text-gray-700 truncate">
                                📦 <strong>{{ $alerte->produit->libelle ?? 'Produit supprimé' }}</strong>
                                <div class="mt-1">
                                    @include('components.badge-type-alerte', ['type' => $alerte->typealerte])
                                </div>
                                <small class="text-gray-400 text-xs">
                                    Déclenché le {{ $alerte->datedeclenchement->format('d/m/Y H:i') }}
                                </small>
                            </a>
                        @endforeach
                    @endif

                    {{-- Articles --}}
                    @if($alertesArticles->isNotEmpty() && ($user->hasRole('admin') || $user->hasRole('magasinier_collation')))
                        <div class="px-4 py-2 text-xs uppercase text-green-500 font-bold bg-gray-100 sticky top-0">
                            Articles
                        </div>
                        @foreach($alertesArticles->sortByDesc('datedeclenchement') as $alerte)
                            <a href="{{ route('alertes-articles.show', $alerte->alerteArt_id) }}"
                               class="block px-4 py-2 hover:bg-green-50 border-b border-gray-200 text-sm text-gray-700 truncate">
                                🧾 <strong>{{ $alerte->article->libelle ?? 'Article supprimé' }}</strong>
                                <div class="mt-1">
                                    @include('components.badge-type-alerte', ['type' => $alerte->typealerte])
                                </div>
                                <small class="text-gray-400 text-xs">
                                    Déclenché le {{ $alerte->datedeclenchement->format('d/m/Y H:i') }}
                                </small>
                            </a>
                        @endforeach
                    @endif

                    @if($alertesProduits->isEmpty() && $alertesArticles->isEmpty())
                        <div class="px-4 py-2 text-gray-500 text-center select-none">
                            Pas de notifications
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Profil --}}
        <div x-data="{ openProfil: false }" class="relative">
            <button @click.stop="openProfil = !openProfil" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center text-lg font-bold">
                    {{ $initiales }}
                </div>
            </button>

            <ul x-show="openProfil" x-transition @click.away="openProfil = false" x-cloak
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-50 mt-1 w-52 p-2 shadow absolute right-0">
                
                <li class="px-2 py-1 text-gray-700"><strong>{{ $user->nom }} {{ $user->prenom }}</strong></li>
                <li class="px-2 py-1 text-gray-500 text-sm">{{ $user->email }}</li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class=" bg-red-200">
                        @csrf
                        <button type="submit">
                            Se deconnecter
                        </button>
                    </form>
                </li>

            </ul>
        </div>

    </div>
</div>

{{-- Script toggle sidebar --}}
<script>
const toggle = document.getElementById('toggleSidebar');
const sidebar = document.getElementById('sidebar');

toggle.addEventListener('click', function(e) {
    e.stopPropagation(); // empêche propagation
    sidebar.classList.toggle('-translate-x-full'); // bascule affichage
});

// Fermer si clic en dehors de la sidebar
document.addEventListener('click', function(e) {
    if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
        sidebar.classList.add('-translate-x-full'); // cache la sidebar
    }
});
</script>
