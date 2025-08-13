<div id="sidebar"
    class="fixed top-0 bottom-0 left-0 w-64 
           bg-red-200 p-6 transition-all duration-300 
           overflow-y-auto border-r border-blue-300">
    <ul class="space-y-4 text-blue-900">

        @php
            $role = auth()->user()->roles->first()->name ?? '';
            $magasin = auth()->user()->magasin_affecte ?? '';

            function menuSection($title, $items) {
                echo '<li>';
                echo '<h3 class="mt-6 mb-2 text-xs font-semibold text-blue-700 uppercase tracking-wider px-2">' . $title . '</h3>';
                echo '<ul class="space-y-1">';
                foreach ($items as $item) {
                    echo '<li>';
                    echo '<a href="' . route($item["route"]) . '" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-blue-900 hover:bg-red-300 hover:text-blue-900 transition-colors">';
                    echo '<i class="' . $item["icon"] . ' text-lg text-blue-600 mr-3"></i>';
                    echo '<span>' . $item["label"] . '</span>';
                    echo '</a></li>';
                }
                echo '</ul>';
                echo '</li>';
                echo '<li><hr class="my-4 border-blue-400"></li>';
            }
        @endphp

        {{-- ADMIN --}}
        @if($role === 'admin' && $magasin === 'admin')
            @php
                menuSection('Employés', [
                    ["route" => "users.index", "icon" => "flaticon-user", "label" => "Employés"],
                ]);

                menuSection('Produits', [
                    ["route" => "produits.index", "icon" => "flaticon-shopping-basket", "label" => "Produits"],
                    ["route" => "consommations-produits.index", "icon" => "flaticon-food", "label" => "Consommation produits"],
                    ["route" => "mouvements-produits.index", "icon" => "flaticon-arrow", "label" => "Mouvements produits"],
                    ["route" => "alertes-produits.index", "icon" => "flaticon-warning-sign", "label" => "Alertes produits"],
                    ["route" => "rapports-produits.index", "icon" => "flaticon-report", "label" => "Rapports produits"],
                ]);

                menuSection('Articles', [
                    ["route" => "articles.index", "icon" => "flaticon-article", "label" => "Articles"],
                    ["route" => "consommations-articles.index", "icon" => "flaticon-food", "label" => "Consommation articles"],
                    ["route" => "mouvements-articles.index", "icon" => "flaticon-arrow", "label" => "Mouvements articles"],
                    ["route" => "alertes-articles.index", "icon" => "flaticon-warning-sign", "label" => "Alertes articles"],
                    ["route" => "rapports-articles.index", "icon" => "flaticon-report", "label" => "Rapports articles"],
                ]);
            @endphp
        @endif

        {{-- MAGASINIER TECHNIQUE --}}
        @if($role === 'magasinier_technique' && $magasin === 'technique')
            @php
                menuSection('Produits', [
                    ["route" => "produits.index", "icon" => "flaticon-shopping-basket", "label" => "Produits"],
                    ["route" => "consommations-produits.index", "icon" => "flaticon-food", "label" => "Consommation produits"],
                    ["route" => "mouvements-produits.index", "icon" => "flaticon-arrow", "label" => "Mouvements produits"],
                    ["route" => "alertes-produits.index", "icon" => "flaticon-warning-sign", "label" => "Alertes produits"],
                    ["route" => "rapports-produits.index", "icon" => "flaticon-report", "label" => "Rapports produits"],
                    ["route" => "users.index", "icon" => "flaticon-user", "label" => "Employés"],
                ]);
            @endphp
        @endif

        {{-- MAGASINIER COLLATION --}}
        @if($role === 'magasinier_collation' && $magasin === 'collation')
            @php
                menuSection('Articles', [
                    ["route" => "articles.index", "icon" => "flaticon-article", "label" => "Articles"],
                    ["route" => "consommations-articles.index", "icon" => "flaticon-food", "label" => "Consommation articles"],
                    ["route" => "mouvements-articles.index", "icon" => "flaticon-arrow", "label" => "Mouvements articles"],
                    ["route" => "alertes-articles.index", "icon" => "flaticon-warning-sign", "label" => "Alertes articles"],
                    ["route" => "rapports-articles.index", "icon" => "flaticon-report", "label" => "Rapports articles"],
                    ["route" => "users.index", "icon" => "flaticon-user", "label" => "Employés"],
                ]);
            @endphp
        @endif
    </ul>
</div>
