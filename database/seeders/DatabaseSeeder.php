<?php

namespace Database\Seeders;

use App\Models\SocialAccount;
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
        // User::factory(10)->create();

        $this->call([
            RolePermissionSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@gkkd-denpasar.id',
        ])->assignRole('Administrator');

        // User biasa: bisa tanpa provider (email), satu provider, atau beberapa sekaligus.
        $andi = User::factory()->create([
            'name' => 'Andi',
            'email' => 'andi@gkkd-denpasar.id',
        ]);

        $dodi = User::factory()->create([
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
