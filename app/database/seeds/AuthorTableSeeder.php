<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/10/2014
 * Time: 11:15 AM
 */
class AuthorTableSeeder extends Seeder {

    public function run()
    {
        Author::create(array(
            'fullname' => 'Admin Root',
            'slug' => 'admin-root',
            'bio' => 'default admin user',
            'user_id' => 1
        ));
    }
} 