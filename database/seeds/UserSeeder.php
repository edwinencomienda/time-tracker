<?php

use App\User;
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
        User::firstOrCreate([
            'name' => 'Edwin Encomienda',
            'email' => 'encomienda000@gmail.com',
            'password' => bcrypt('test123')
        ]);
    }
}
