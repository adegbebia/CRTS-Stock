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
        $role_names = ['directeur', 'responsable_surveillant', 'responsable technique'];

        // Création des rôles
        $roles = [];
        foreach ($role_names as $roleName) {
            $roles[$roleName] = Role::create(['name' => $roleName]);
        }

        // Liste des permissions
        $permission_names = [
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

        // Création des permissions
        $permissions = [];
        foreach ($permission_names as $permissionName) {
            $permissions[] = Permission::create(['name' => $permissionName]);
        }

        // Attribution de toutes les permissions à tous les rôles
        foreach ($roles as $role) {
            $role->givePermissionTo($permissions);
        }
    }
}
