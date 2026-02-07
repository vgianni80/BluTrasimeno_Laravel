<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Utente admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Amministratore',
                'password' => Hash::make('password'),
            ]
        );

        // Impostazioni di default
        foreach (Setting::getDefaults() as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
