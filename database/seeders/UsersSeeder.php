<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
                'nick_name' => 'userAdmin',
                'email' => 'userAdmin@example.com',
                'password' => Hash::make('passAdmin123'),
            ]);
        $admin->assignRole('Administrador');

        $responsable = User::create([
                'nick_name' => 'userResponsable',
                'email' => 'userResponsable@example.com',
                'password' => Hash::make('passResponsable123'),
        ]);
        $responsable->assignRole('Responsable');

        $asignado = User::create([
                'nick_name' => 'userAsignado',
                'email' => 'userAsignado@example.com',
                'password' => Hash::make('passAsignado123'),
        ]);
        $responsable->assignRole('Asignado');
    }
}
