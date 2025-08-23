@extends('layouts.app')

@section('title', 'Dashboard - Alertes')

@section('content')
    <div id="dashboardContent" class="transition-all duration-300 ml-64 p-6 bg-gray-50 min-h-screen">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800 tracking-wide">Bienvenue sur le Dashboard</h1>

        {{-- SweetAlert message de succès --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        {{-- Alertes Produits --}}
        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('magasinier_technique'))
            <section class="mb-10">
                <h2 class="text-3xl font-semibold mb-4 text-blue-500 border-b-2 border-blue-400 pb-1 tracking-wide">Alertes
                    Produits</h2>
                @if ($alertesProduits->count())
                    <ul class="list-disc list-inside space-y-2 text-gray-700 text-base leading-relaxed">
                        @foreach ($alertesProduits as $alerte)
                            <li class="bg-white rounded-md shadow-sm p-3 hover:bg-red-50 transition duration-150">
                                <span class="font-mono text-xs text-gray-600 mr-2">[{{ $alerte->datedeclenchement }}]</span>
                                <span class="font-semibold">Produit :</span>
                                <span class="font-medium text-gray-900">
                                    {{ $alerte->produit->libelle ?? 'Produit supprimé' }}
                                </span>
                                <span class="font-semibold">Type d'alerte :</span>

                                @switch($alerte->typealerte)
                                    @case('Alerte rouge')
                                        <span class="text-red-600 font-semibold">Stock critique</span>
                                    @break

                                    @case('Alerte orange')
                                        <span class="text-orange-500 font-semibold">Stock faible</span>
                                    @break

                                    @case('Rupture de stock')
                                        <span class="text-yellow-500 font-semibold">Attention stock</span>
                                    @break

                                    @case('Alerte verte')
                                        <span class="text-green-600 font-semibold">Stock acceptable</span>
                                    @break

                                    @default
                                        <span class="text-gray-600 font-semibold">Produit Périmé</span>
                                @endswitch
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 italic text-base">Aucune alerte produit pour le moment.</p>
                @endif
                <hr class="mt-6 border-gray-300" />
            </section>
        @endif

        {{-- Alertes Articles --}}
        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('magasinier_collation'))
            <section>
                <h2 class="text-3xl font-semibold mb-4 text-blue-500 border-b-2 border-blue-400 pb-1 tracking-wide">Alertes
                    Articles</h2>
                @if ($alertesArticles->count())
                    <ul class="list-disc list-inside space-y-2 text-gray-700 text-base leading-relaxed">
                        @foreach ($alertesArticles as $alerte)
                            <li class="bg-white rounded-md shadow-sm p-3 hover:bg-blue-50 transition duration-150">
                                <span class="font-mono text-xs text-gray-400 mr-2">[{{ $alerte->datedeclenchement }}]</span>
                                <span class="font-semibold text-blue-600">Article :</span>
                                <span
                                    class="font-medium text-gray-900">{{ $alerte->article->libelle ?? 'Article supprimé' }}
                                </span>
                                <span class="font-semibold text-blue-600">Type d'alerte :</span>
                                <span class="italic text-blue-500">{{ $alerte->typealerte }}</span>
                                
                                @switch($alerte->typealerte)
                                    @case('Alerte rouge')
                                        <span class="text-red-600 font-semibold">Stock critique</span>
                                    @break

                                    @case('Alerte orange')
                                        <span class="text-orange-500 font-semibold">Stock faible</span>
                                    @break

                                    @case('Rupture de stock')
                                        <span class="text-yellow-500 font-semibold">Attention stock</span>
                                    @break

                                    @case('Alerte verte')
                                        <span class="text-green-600 font-semibold">Stock acceptable</span>
                                    @break

                                    @default
                                        <span class="text-gray-600 font-semibold">Produit Périmé</span>
                                @endswitch
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 italic text-base">Aucune alerte article pour le moment.</p>
                @endif
            </section>
        @endif
    </div>

    @push('scripts')
        <script>
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                let sidebar = document.getElementById('sidebar');
                let content = document.getElementById('dashboardContent');

                sidebar.classList.toggle('-translate-x-full');
                if (sidebar.classList.contains('-translate-x-full')) {
                    content.classList.remove('ml-64');
                    content.classList.add('ml-0');
                } else {
                    content.classList.remove('ml-0');
                    content.classList.add('ml-64');
                }
            });
        </script>
    @endpush
@endsection
