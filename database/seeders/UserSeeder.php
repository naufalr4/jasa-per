<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'email_verified_at' => now()

        ]);

        User::create([
            'name' => 'teknisi1',
            'email' => 'teknisi1@gmail.com',
            'password' => bcrypt('123'),
            'email_verified_at' => now()

        ]);

        User::create([
            'name' => 'teknisi2',
            'email' => 'teknisi2@admin.com',
            'password' => bcrypt('123'),
            'email_verified_at' => now()

        ]);
    }
}
