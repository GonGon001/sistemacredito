<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::whereIn('email', [
            'admin@example.com', 'asesor@example.com', 'usuario@example.com', 'admin@gmail.com',
        ])->delete();

        User::updateOrCreate(['email' => 'admi@gmail.com'], [
            'name' => 'Administrador', 'password' => Hash::make('admin123'), 'role' => 'administrador',
        ]);
        User::updateOrCreate(['email' => 'asesor@gmail.com'], [
            'name' => 'Asesor de Crédito', 'password' => Hash::make('admin123'), 'role' => 'asesor',
        ]);
        $usuario = User::updateOrCreate(['email' => 'usuario@gmail.com'], [
            'name' => 'Usuario', 'password' => Hash::make('admin123'), 'role' => 'usuario',
        ]);

        Cliente::updateOrCreate(['user_id' => $usuario->id], [
            'nombre' => $usuario->name,
            'fechanac' => '1990-01-01',
            'email' => $usuario->email,
        ]);
    }
}
