<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@centre-oudghiri.com');
        $adminPassword = env('ADMIN_PASSWORD', 'admin12345');

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Administrateur',
                'password' => \Hash::make($adminPassword),
                'email_verified_at' => now(),
            ]
        );

        $this->call(ServiceSeeder::class);
    }
}
