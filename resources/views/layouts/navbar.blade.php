@php
use App\Models\AlerteProduit;
use App\Models\AlerteArticle;

$user = auth()->user();

if ($user->hasRole('admin')) {
$alertesProduits = AlerteProduit::with('produit')->get();
$alertesArticles = AlerteArticle::with('article')->get();
$nbAlertes = $alertesProduits->count() + $alertesArticles->count();
} elseif ($user->hasRole('magasinier_technique')) {
$alertesProduits = AlerteProduit::with('produit')->get();
$alertesArticles = collect(); // vide, pas d'alertes articles pour ce rôle
$nbAlertes = $alertesProduits->count();
} elseif ($user->hasRole('magasinier_collation')) {
$alertesProduits = collect(); // vide, pas d'alertes produits pour ce rôle
$alertesArticles = AlerteArticle::with('article')->get();
$nbAlertes = $alertesArticles->count();
} else {
$alertesProduits = collect();
$alertesArticles = collect();
$nbAlertes = 0;
}
@endphp


<div class="navbar bg-base-100 shadow-sm">
    <div class="navbar-start">
        <div class="dropdown">
            {{-- <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /> </svg>
      </div> --}}
            <div> <a href="#" id="toggleSidebar">☰</a>
            </div>
            {{-- <ul 
      
    tabindex="0"
    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow"
>
    <li>
        <a href="#" id="toggleSidebar">📂 Menu Sidebar</a>
    </li>
</ul> --}}
        </div>
    </div>
    <div class="navbar-center">
        <a class="btn btn-ghost text-xl">crts-stock</a>
    </div>
    <div class="navbar-end">
        <button class="btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        <div x-data="{ open: false }" class="relative">
            <!-- Bouton Notification -->
            <button
                @click="open = !open"
                class="btn btn-ghost btn-circle relative"
                aria-label="Notifications">

                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11
                                a6.002 6.002 0 00-4-5.659V5
                                a2 2 0 10-4 0v.341
                                C7.67 6.165 6 8.388 6 11v3.159
                                c0 .538-.214 1.055-.595 1.436L4 17h5
                                m6 0v1a3 3 0 11-6 0v-1
                                m6 0H9" />
                    </svg>

                    @if ($nbAlertes > 0)
                    <span class="badge badge-xs bg-red-600 text-white absolute -top-1.5 -right-2">
                        {{ $nbAlertes }}
                    </span>
                    @endif
                </div>
            </button>

            <!-- Liste des notifications -->
            <div x-show="open"
                x-transition
                @click.away="open = false"
                x-cloak
                class="origin-top-right absolute right-0 mt-2 w-96 rounded-md shadow-lg 
                        bg-white ring-1 ring-black ring-opacity-5 z-50">

                <div class="py-2 max-h-96 overflow-y-auto 
                            scrollbar-thin scrollbar-thumb-indigo-400 scrollbar-track-indigo-100">

                    {{-- Produits --}}
                    @if($alertesProduits->isNotEmpty() && ($user->hasRole('admin') || $user->hasRole('magasinier_technique')))
                    <div class="px-4 py-2 text-xs uppercase text-indigo-500 font-bold bg-gray-100 sticky top-0">Produits</div>
                    @foreach($alertesProduits->sortByDesc('datedeclenchement') as $alerte)
                    <a href="{{ route('alertes-produits.show', $alerte->alerteProd_id) }}"
                        class="block px-4 py-2 hover:bg-indigo-50 border-b border-gray-200 text-sm text-gray-700 truncate">
                        📦 <strong>{{ $alerte->produit->libelle ?? 'Produit supprimé' }}</strong>
                        <div class="mt-1">
                            @include('components.badge-type-alerte', ['type' => $alerte->typealerte])
                        </div>
                        <small class="text-gray-400">
                            Déclenché le {{ $alerte->datedeclenchement->format('d/m/Y H:i') }}
                        </small>
                    </a>
                    @endforeach
                    @endif

                    {{-- Articles --}}
                    @if($alertesArticles->isNotEmpty() && ($user->hasRole('admin') || $user->hasRole('magasinier_collation')))
                    <div class="px-4 py-2 text-xs uppercase text-green-500 font-bold bg-gray-100 sticky top-0">Articles</div>
                    @foreach($alertesArticles->sortByDesc('datedeclenchement') as $alerte)
                    <a href="{{ route('alertes-articles.show', $alerte->alerteArt_id) }}"
                        class="block px-4 py-2 hover:bg-green-50 border-b border-gray-200 text-sm text-gray-700 truncate">
                        🧾 <strong>{{ $alerte->article->libelle ?? 'Article supprimé' }}</strong>
                        <div class="mt-1">
                            @include('components.badge-type-alerte', ['type' => $alerte->typealerte])
                        </div>
                        <small class="text-gray-400">
                            Déclenché le {{ $alerte->datedeclenchement->format('d/m/Y H:i') }}
                        </small>
                    </a>
                    @endforeach
                    @endif

                    {{-- Pas de notifications --}}
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

        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    <img alt="Tailwind CSS Navbar component"
                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                </div>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li>
                    <a class="justify-between">
                        Profile
                        <span class="badge">New</span>
                    </a>
                </li>


                <!-- <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <span class="badge">Logout</span>
                </form> -->

                <li>
                    <form  action="{{route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">
                            Logout
                        </button>
                    </form>
                </li>


            </ul>
        </div>
    </div>
</div>