<?php

namespace Database\Seeders;

use App\Models\Teknisi;
use Illuminate\Database\Seeder;

class TeknisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Teknisi::create([
            'name' => 'teknisi1',
            'email' => 'teknisi1@gmail.com',
            'password' => bcrypt('123'),
            'email_verified_at' => now()

        ]);

        Teknisi::create([
            'name' => 'teknisi2',
            'email' => 'teknisi2@admin.com',
            'password' => bcrypt('123'),
            'email_verified_at' => now()

        ]);
    }
}
