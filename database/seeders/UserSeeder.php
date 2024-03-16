<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' =>1,
                'level_id' =>1,
                'username' => 'admin',
                'nama' => 'Administator',
                'password' => Hash::make('12345'),
            ],
            [
                'user_id' =>2,
                'level_id' =>2,
                'username' =>'manager',
                'nama' => 'Manager',
                'password' => Hash::make('12345'),
            ],
            [
                'user_Id' => 3,
                'level_id' => 3,
                'username' => 'staff',
                'nama' => 'Staff/Kasir',
                'password' => Hash::make('12345')
            ],
        ];
        DB::table('m_user')->insert($data);
    }
}