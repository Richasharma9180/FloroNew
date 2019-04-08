<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'id' => Uuid::generate(),
            'first_name' => 'Richa',
            'last_name' => 'Sharma',
            'username' => 'Richasharma9180',
            'email' => 'ri.sharma@easternenterprise.com',
            'password' => bcrypt('secret'),
            'address' => 'Nyati Tech Park, Pune India',
            'house_number' => '4',
            'postal_code' => '123456',
            'city' => 'Pune',
            'telephone_number' => '9878777888'
        ]);
        factory(\App\User::class, 10000)->create();
        //$users = factory(App\User::class, 1000)->create();
    } 
}
