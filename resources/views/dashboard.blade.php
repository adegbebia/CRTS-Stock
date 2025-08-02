<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Alertes</title>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <h1>Bienvenue sur le Dashboard</h1>

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
    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('magasinier_technique'))
        <h2>Alertes Produits</h2>
        @if($alertesProduits->count())
            <ul>
                @foreach($alertesProduits as $alerte)
                    <li>
                        [{{ $alerte->datedeclenchement }}] 
                        Produit : {{ $alerte->produit->libelle ?? 'Produit supprimé' }} - 
                        Type d'alerte : {{ $alerte->typealerte }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucune alerte produit pour le moment.</p>
        @endif

        <hr>
    @endif

    {{-- Alertes Articles --}}
    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('magasinier_collation'))
        <h2>Alertes Articles</h2>
        @if($alertesArticles->count())
            <ul>
                @foreach($alertesArticles as $alerte)
                    <li>
                        [{{ $alerte->datedeclenchement }}] 
                        Article : {{ $alerte->article->libelle ?? 'Article supprimé' }} - 
                        Type d'alerte : {{ $alerte->typealerte }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucune alerte article pour le moment.</p>
        @endif
    @endif

</body>
</html>
