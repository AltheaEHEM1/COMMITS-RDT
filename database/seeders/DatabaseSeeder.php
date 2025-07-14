<?php

namespace Database\Seeders;

use App\Models\Boxes;
use App\Models\User;
use App\Models\Medicine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database. - php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MedicineSeeder::class,
        ]);

        // // Create test user
        // $user = User::factory()->create([
        //     'id' => 1,
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('Pass12345')
        // ]);

        // // Create boxes first
        // $boxes = Boxes::factory()
        //     ->count(10)
        //     ->create([
        //         'user_id' => $user->id
        //     ]);

        // // Create medicines for each box
        // foreach ($boxes as $box) {
        //     Medicine::factory()->create([
        //         'box_id' => $box->id
        //     ]);
        // }
    }
}
