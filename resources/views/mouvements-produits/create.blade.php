<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1" /> -->
    <title>Ajout de mouvement</title>
</head>

<body>

    <h2>Ajouter un mouvement</h2>

    {{-- Affichage des erreurs --}}
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mouvements-produits.store') }}" method="POST">
        @csrf

        @if ($produitSelectionne)
            @php
                $produit = $produits->find($produitSelectionne);
            @endphp
            <p>Produit sélectionné : <strong>{{ $produit->libelle ?? 'N/A' }}</strong></p>
            <input type="hidden" name="produit_id" value="{{ $produitSelectionne }}">
        @else
            <label for="produit_id">Produit</label>
            <select name="produit_id" id="produit_id" required>
                <option value="">-- Sélectionner un produit --</option>
                @foreach ($produits as $produit)
                    <option value="{{ $produit->produit_id }}" @if (old('produit_id') == $produit->produit_id) selected @endif>
                        {{ $produit->libelle }}
                    </option>
                @endforeach
            </select>
        @endif

        <a href="{{ route('produits.create') }}" target="_blank">Ajouter un produit</a>
        <p><em>Si le produit n’apparaît pas, créez-le puis actualisez cette page.</em></p>

        <label for="origine">Origine</label>
        <input type="text" name="origine" id="origine" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :" value="{{ old('origine') }}"  />

        <label for="quantite_commandee">Quantité commandée</label>
        <input type="number" name="quantite_commandee" id="quantite_commandee" min="1" required value="{{ old('quantite_commandee') }}" />

        <label for="quantite_entree">Quantité entrée</label>
        <input type="number" name="quantite_entree" id="quantite_entree" min="1" value="{{ old('quantite_entree') }}" />

        <label for="quantite_sortie">Quantité sortie</label>
        <input type="number" name="quantite_sortie" id="quantite_sortie" min="1" value="{{ old('quantite_sortie') }}" />

        <label for="stock_debut_mois">Stock début du mois</label>
        <input type="number" name="stock_debut_mois" id="stock_debut_mois" min="1" required value="{{ old('stock_debut_mois') }}" />

        <label for="avarie">Avarie</label>
        <input type="number" name="avarie" id="avarie" min="1" value="{{ old('avarie') }}" />

        <label for="observation">Observation</label>
        <textarea name="observation" id="observation" >{{ old('observation') }}</textarea>

        <button type="submit">Créer</button>
    </form>

    <hr />

    <h3>Liste des mouvements déjà créés</h3>

    @if ($mouvements->count())
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Date</th>
                    <th>Origine</th>
                    <th>Quantité commandée</th>
                    <th>Quantité entrée</th>
                    <th>Quantité sortie</th>
                    <th>Avarie</th>
                    <th>Stock du jour</th>
                    <th>Observation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mouvements as $mouvement)
                    <tr>
                        <td>{{ $mouvement->produit->libelle ?? 'N/A' }}</td>
                        <td>{{ $mouvement->date }}</td>
                        <td>{{ $mouvement->origine }}</td>
                        <td>{{ $mouvement->quantite_commandee }}</td>
                        <td>{{ $mouvement->quantite_entree }}</td>
                        <td>{{ $mouvement->quantite_sortie }}</td>
                        <td>{{ $mouvement->avarie }}</td>
                        <td>{{ $mouvement->stock_jour }}</td>
                        <td>{{ $mouvement->observation }}</td>
                        <td>
                            <a href="{{ route('mouvements-produits.edit', $mouvement->mouvementProd_id) }}" title="Modifier">
                                <button type="button">
                                    <!-- SVG original conservé -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1
                           2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897
                           1.13L6 18l.8-2.685a4.5 4.5 0 0 1
                           1.13-1.897l8.932-8.931Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 14v4.75A2.25 2.25 0 0 1
                           15.75 21H5.25A2.25 2.25 0 0 1
                           3 18.75V8.25A2.25 2.25 0 0 1
                           5.25 6H10" />
                                    </svg>
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun mouvement enregistré pour le moment.</p>
    @endif

</body>
<!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Notification de succès --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: {{ Js::from(session('success')) }},
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    {{-- Notification d’échec --}}
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: {{ Js::from(session('error')) }},
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif


</html>
