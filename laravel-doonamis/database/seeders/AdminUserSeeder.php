<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@admin.com';

        $existingUser = User::where('email', $email)->first();

        if (!$existingUser) {
            User::create([
                'name' => 'Administrador',
                'email' => $email,
                'password' => Hash::make('12345'),
            ]);

            $this->command->info('Usuario admin creado correctamente.');
        } else {
            $this->command->info('El usuario admin ya existe. No se creó uno nuevo.');
        }
    }
}
