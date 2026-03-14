<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

//        Create Admin
        User::create([
            'name' => 'Hamza Siddique',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role' => 'admin'
        ]);

       \App\Models\User::factory(5)->create();
       \App\Models\Player::factory(10)->create();
       //\App\Models\Tournament::factory(50)->create();


        $user1 = Player::find(1);
        $user1->highlighted = 1;
        $user1->save();

        $user1 = Player::find(2);
        $user1->highlighted = 1;
        $user1->save();


    }
}
