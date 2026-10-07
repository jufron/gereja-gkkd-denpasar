<?php

namespace Database\Seeders;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed contoh user: administrator, user email-only,
     * single-provider, dan multi-provider.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@gkkd-denpasar.id',
        ])->assignRole('Administrator');

        $andi = User::factory()->create([
            'name' => 'Andi',
            'email' => 'andi@gkkd-denpasar.id',
        ]);

        User::factory()->create([
            'name' => 'Dodi',
            'email' => 'dodi@gkkd-denpasar.id',
        ]);

        $aldi = User::factory()->create([
            'name' => 'Aldi',
            'email' => 'aldi@gkkd-denpasar.id',
        ]);

        // Andi: Google + Facebook (multi-provider).
        SocialAccount::factory()->google()->create(['user_id' => $andi->id]);
        SocialAccount::factory()->facebook()->create(['user_id' => $andi->id]);

        // Dodi: hanya email (tidak ada provider).

        // Aldi: Google saja.
        SocialAccount::factory()->google()->create(['user_id' => $aldi->id]);
    }
}
