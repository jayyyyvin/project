<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = 'Jay Alvin Fermano Melgazo';
        $email = 'ja.melgazo@mlgcl.edu.ph';        

        // Insert data into the database
        DB::table('users')->insert ([
            [
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),

            ],
        ]);
    }
}
