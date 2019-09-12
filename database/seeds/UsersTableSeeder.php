<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'status' => true,
        ]);

        // User::create([
        //     'name' => 'kasir',
        //     'email' => 'kasir@kasir.com',
        //     'password' => bcrypt('kasir'),
        //     'status' => true,
        // ]);
    }
}
