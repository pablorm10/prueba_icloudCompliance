<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear los permisos
        $permisos = [
            'Ver documentos',
            'Editar documentos',
            'Borrar documentos',
            'Crear documentos',
            'Aprobar documentos'
        ];

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }

        // Crear roles
        $adminRole = Role::create(['name' => 'Administrador']);
        $responsableRole = Role::create(['name' => 'Responsable']);
        $asignadoRole = Role::create(['name' => 'Asignado']);

        // Asignar permisos a roles
        $adminRole->givePermissionTo(Permission::all());
        $responsableRole->givePermissionTo(['Crear documentos', 'Ver documentos']);
        $asignadoRole->givePermissionTo(['Ver documentos']);
    }
}
