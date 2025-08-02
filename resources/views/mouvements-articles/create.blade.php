<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajout de mouvement</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
     @php
        $peutModifier = auth()->user()->hasRole('magasinier_collation') && auth()->user()->magasin_affecte === 'collation';
    @endphp

    <h2>Ajouter un mouvement</h2>

    @if (!$peutModifier)
        <p style="color:red;">⚠️ Vous n’êtes pas autorisé à créer un mouvement.</p>
    @endif

    <!-- {{-- Affichage des erreurs --}}
    {{-- @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}} -->

    <form action="{{ $peutModifier ? route('mouvements-articles.store') : '#' }}" method="POST"
        {{ !$peutModifier ? 'onsubmit=return false' : '' }}>
        @csrf

        {{-- Sélection ou affichage de l'articles --}}


        <div>

            @if ($articleSelectionne)
                @php
                    $article = $articles->find($articleSelectionne);
                @endphp
                <div>
                    <p>Article sélectionné : <strong>{{ $article->libelle ?? 'N/A' }}</strong></p>
                    <input type="hidden" name="article_id" value="{{ $articleSelectionne }}">
                </div>
            @else
                <div>
                    <label for="article_id">Article</label>
                    <select name="article_id" id="article_id" required>
                        <option value="">-- Sélectionner un article --</option>
                        @foreach ($articles as $article)
                            <option value="{{ $article->article_id }}" @if (old('article_id') == $article->article_id) selected @endif>
                                {{ $article->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('article_id')
                        <div style="color:red;">{{ $message }}</div>
                    @enderror
                </div>
            @endif
        </div>
        <div>
            <a href="{{ route('articles.create') }}" target="_blank">Ajouter un article</a>
            <p><em>Si l'article n’apparaît pas, créez-le puis actualisez cette page.</em></p>
        </div>

        <div>
            <label for="origine">Origine</label>
            <input type="text" name="origine" id="origine" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :"
                title="Ne doit pas contenir les caractères , ; :" value="{{ old('origine') }}" {{ !$peutModifier ? 'disabled' : '' }}/>
            @error('origine')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="quantite_commandee">Quantité commandée</label>
            <input type="number" name="quantite_commandee" id="quantite_commandee" min="1" required
                value="{{ old('quantite_commandee') }}" {{ !$peutModifier ? 'disabled' : '' }}/>
            @error('quantite_commandee')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="quantite_entree">Quantité entrée</label>
            <input type="number" name="quantite_entree" id="quantite_entree" min="1"
                value="{{ old('quantite_entree') }}" {{ !$peutModifier ? 'disabled' : '' }}/>
            @error('quantite_entree')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="quantite_sortie">Quantité sortie</label>
            <input type="number" name="quantite_sortie" id="quantite_sortie" min="1"
                value="{{ old('quantite_sortie') }}" {{ !$peutModifier ? 'disabled' : '' }}/>
            @error('quantite_sortie')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="stock_debut_mois">Stock début du mois</label>
            <input type="number" name="stock_debut_mois" id="stock_debut_mois" min="1" required
                value="{{ old('stock_debut_mois') }}" {{ !$peutModifier ? 'disabled' : '' }}/>
            @error('stock_debut_mois')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="avarie">Avarie</label>
            <input type="number" name="avarie" id="avarie" min="1" 
                value="{{ old('avarie') }}" {{ !$peutModifier ? 'disabled' : '' }}/>
            @error('avarie')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="observation">Observation</label>
            <textarea name="observation" id="observation" {{ !$peutModifier ? 'disabled' : '' }}>{{ old('observation') }}</textarea>
            @error('observation')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            @if ($peutModifier)
                <button type="submit">Créer</button>
            @endif        
        </div>
    </form>


    <hr/>

    <h3>Liste des mouvements déjà créés</h3>

    @if ($mouvements->count())
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Article</th>
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
                        <td>{{ $mouvement->article->libelle ?? 'N/A' }}</td>
                        <td>{{ $mouvement->date }}</td>
                        <td>{{ $mouvement->origine }}</td>
                        <td>{{ $mouvement->quantite_commandee }}</td>
                        <td>{{ $mouvement->quantite_entree }}</td>
                        <td>{{ $mouvement->quantite_sortie }}</td>
                        <td>{{ $mouvement->avarie }}</td>
                        <td>{{ $mouvement->stock_jour }}</td>
                        <td>{{ $mouvement->observation }}</td>
                        <td>
                            <a href="{{ route('mouvements-articles.edit', $mouvement->mouvementArt_id) }}"
                                title="Modifier">
                                <button type="button">
                                    <!-- SVG original conservé -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1
                           2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897
                           1.13L6 18l.8-2.685a4.5 4.5 0 0 1
                           1.13-1.897l8.932-8.931Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 14v4.75A2.25 2.25 0 0 1
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

    <!-- SweetAlert2 CDN -->

    {{-- Notification de succès --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
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
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: {{ Js::from(session('error')) }},
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

</body>

</html>
