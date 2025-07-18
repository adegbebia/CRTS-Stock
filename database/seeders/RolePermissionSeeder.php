<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

        $role_names=['directeur','responsable_surveillant','responsable technique'];

        $roles=Role::create([
            'name'=>'directeur',
            'name'=>'responsable_surveillant',
            'name'=>'responsable technique',
        ]);
        // Création des permissions
        $permissions_names =[

            'produits-create',
            'produits-edit',
            'produits-delete',
            'produits-view',

            'mouvements-create',
            'mouvements-edit',
            'mouvements-delete',
            'mouvements-view',

            'consommations-create',
            'consommations-edit',
            'consommations-delete',
            'consommations-view',

            'alertes-view',

            'rapports-view',
            'rapports-generate',
        ];


        $permission1=Permission::create([

            'name'=>'produits-create'

        ]);

        $permission2=Permission::create([

            'name'=>'produits-edit'

        ]);

        $permission3=Permission::create([

            'name'=>'produits-delete'

        ]);

        $permission4=Permission::create([

            'name'=>'produits-view'

        ]);


        $permission5=Permission::create([

            'name'=>'mouvements-create'

        ]);


        $permission6=Permission::create([

            'name'=>'mouvements-edit'

        ]);

        $permission7=Permission::create([

            'name'=>'mouvements-delete'

        ]);


        $permission8=Permission::create([

            'name'=>'mouvements-view'

        ]);

        $permission9=Permission::create([

            'name'=>'consommations-create'

        ]);

        $permission10=Permission::create([

            'name'=>'consommations-edit'

        ]);

        $permission11=Permission::create([

            'name'=>'consommations-delete'

        ]);

        $permission12=Permission::create([

            'name'=>'consommations-view'

        ]);

        $permission13=Permission::create([

            'name'=>'alertes-view'

        ]);

        $permission14=Permission::create([

            'name'=>'rapports-view'

        ]);

        $permission15=Permission::create([

            'name'=>'rapports-generate'

        ]);

        $roles->givePermissionTo([

            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $permission5,
            $permission6,
            $permission7,
            $permission8,
            $permission9,
            $permission10,
            $permission11,
            $permission12,
            $permission13,
            $permission14,
            $permission15,


        ]);


        
    }
}

    

