<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo admin
        User::create([
        	'code' => 'ADMIN',
        	'name' => 'Admin',
        	'email' => 'admin@gmail.com',
        	'gender' => 'Nam',
        	'password' => bcrypt('123123123'),
        	'birthday' => '1995-08-08',
        	'phone' => '0123123123',
        	'address' => 'Hà Nội',
        ]);
    }
}
