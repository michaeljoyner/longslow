<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'email' => 'admin@example.com',
            'password' => Hash::make('password1'),
            'role_id' => 1
        ));
    }

}