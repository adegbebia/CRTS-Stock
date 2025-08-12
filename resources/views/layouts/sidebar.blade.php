<div id="sidebar" class="bg-white w-64 p-6 shadow-lg transition-all duration-300 overflow-y-auto border-r">
    <ul class="menu p-2 bg-white text-gray-700 rounded-lg">

        @php
            $role = auth()->user()->roles->first()->name ?? '';
            $magasin = auth()->user()->magasin_affecte ?? '';

            function menuSection($title, $items) {
                echo '<li class="mt-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wide px-2">' . $title . '</li>';
                foreach ($items as $item) {
                    echo '<li>';
                    echo '<a href="' . route($item["route"]) . '" class="flex items-center p-2 rounded-lg transition-colors duration-150 hover:bg-gray-100">';
                    echo '<i class="' . $item["icon"] . ' text-lg text-gray-500 mr-3"></i>';
                    echo '<span class="text-sm font-medium">' . $item["label"] . '</span>';
                    echo '</a></li>';
                }
                echo '<li><hr class="my-3 border-gray-200"></li>';
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
