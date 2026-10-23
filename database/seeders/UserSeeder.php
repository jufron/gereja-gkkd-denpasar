<?php

namespace Database\Seeders;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed contoh user (idempotent): administrator, tim pelayanan,
     * user email-only, single-provider, dan multi-provider.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gkkd-denpasar.id'],
            ['name' => 'Administrator', 'email_verified_at' => now(), 'password' => 'password'],
        )->assignRole('Administrator');

        $andi = User::firstOrCreate(
            ['email' => 'andi@gkkd-denpasar.id'],
            ['name' => 'Andi', 'email_verified_at' => now(), 'password' => 'password'],
        );
        $andi->assignRole('Tim Pelayanan');

        User::firstOrCreate(
            ['email' => 'dodi@gkkd-denpasar.id'],
            ['name' => 'Dodi', 'email_verified_at' => now(), 'password' => 'password'],
        );

        $aldi = User::firstOrCreate(
            ['email' => 'aldi@gkkd-denpasar.id'],
            ['name' => 'Aldi', 'email_verified_at' => now(), 'password' => 'password'],
        );
        $aldi->assignRole('Tim Pelayanan');

        // Andi: Google + Facebook (multi-provider).
        SocialAccount::firstOrCreate(
            ['user_id' => $andi->id, 'provider' => 'google'],
            ['provider_id' => fake()->numerify('##################')],
        );
        SocialAccount::firstOrCreate(
            ['user_id' => $andi->id, 'provider' => 'facebook'],
            ['provider_id' => (string) fake()->numberBetween(10_000_000_000, 99_999_999_999)],
        );

        // Dodi: hanya email (tidak ada provider).

        // Aldi: Google saja.
        SocialAccount::firstOrCreate(
            ['user_id' => $aldi->id, 'provider' => 'google'],
            ['provider_id' => fake()->numerify('##################')],
        );
    }
}
