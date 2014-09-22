<?php

class CategoryTableSeeder extends Seeder {

	public function run() {

		DB::table('categories')->truncate();

		Category::create(array(
			'category' => 'general',
			'slug' => 'general',
            'description' => 'The default category',
            'cover' => 'images/write.jpg'
		));


	}
}