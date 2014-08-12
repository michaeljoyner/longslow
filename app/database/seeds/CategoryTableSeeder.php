<?php

class CategoryTableSeeder extends Seeder {

	public function run() {

		DB::table('categories')->truncate();

		Category::create(array(
			'category' => 'sports',
			'slug' => 'sports',
		));

		Category::create(array(
			'category' => 'news',
			'slug' => 'news',
		));

		Category::create(array(
			'category' => 'business',
			'slug' => 'business',
		));

		Category::create(array(
			'category' => 'entertainment',
			'slug' => 'entertainment',
		));
	}
}