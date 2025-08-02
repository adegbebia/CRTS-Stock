<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Liste des rôles
        $role_names = ['admin', 'magasinier_technique', 'magasinier_collation'];

        // Création des rôles
        $roles = [];
        foreach ($role_names as $roleName) {
            $roles[$roleName] = Role::create(['name' => $roleName]);
        }

        // Liste des permissions
        $permission_names = [
            // GESTION UTILISATEURS
            'users-create',
            'users-edit',
            'users-delete',
            'users-view',

            // PRODUITS
            'produits-create',
            'produits-edit',
            'produits-delete',
            'produits-view',

            'mouvementsP-create',
            'mouvementsP-edit',
            'mouvementsP-delete',
            'mouvementsP-view',

            'consommationsP-create',
            'consommationsP-edit',
            'consommationsP-delete',
            'consommationsP-view',

            'alertesP-view',
            'rapportsP-view',
            'rapportsP-generate',

            // ARTICLES
            'articles-create',
            'articles-edit',
            'articles-delete',
            'articles-view',

            'mouvementsA-create',
            'mouvementsA-edit',
            'mouvementsA-delete',
            'mouvementsA-view',

            'consommationsA-create',
            'consommationsA-edit',
            'consommationsA-delete',
            'consommationsA-view',

            'alertesA-view',
            'rapportsA-view',
            'rapportsA-generate',
        ];

        // Création des permissions
        $permissions = [];
        foreach ($permission_names as $permissionName) {
            $permissions[] = Permission::create(['name' => $permissionName]);
        }

        // Attribution des permissions spécifiques aux rôles
        // Admin permissions
        $roles['admin']->givePermissionTo([
            'users-view',
            'users-edit',
            'users-delete',
            'produits-view',
            'mouvementsP-view',
            'consommationsP-view',
            'alertesP-view',
            'rapportsP-view',
            'rapportsP-generate',
            'articles-view',
            'mouvementsA-view',
            'consommationsA-view',
            'alertesA-view',
            'rapportsA-view',
            'rapportsA-generate',
        ]);

        // Magasinier technique permissions
        $roles['magasinier_technique']->givePermissionTo([
            'produits-create',
            'produits-edit',
            'produits-delete',
            'produits-view',
            'users-view',
            'mouvementsP-create',
            'mouvementsP-edit',
            'mouvementsP-delete',
            'mouvementsP-view',
            'consommationsP-create',
            'consommationsP-edit',
            'consommationsP-delete',
            'consommationsP-view',
            'alertesP-view',
            'rapportsP-view',
            'rapportsP-generate',
        ]);

        // Magasinier collation permissions
        $roles['magasinier_collation']->givePermissionTo([
            'articles-create',
            'articles-edit',
            'articles-delete',
            'articles-view',
            'users-view',
            'mouvementsA-create',
            'mouvementsA-edit',
            'mouvementsA-delete',
            'mouvementsA-view',
            'consommationsA-create',
            'consommationsA-edit',
            'consommationsA-delete',
            'consommationsA-view',
            'alertesA-view',
            'rapportsA-view',
            'rapportsA-generate',
        ]);
    }
}
