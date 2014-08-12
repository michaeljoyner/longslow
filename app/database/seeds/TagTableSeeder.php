<?php

class TagTableSeeder extends Seeder {

	public function run() {
		DB::table('tags')->truncate();

		Tag::create(array(
			'tag' => 'silly',
			'slug' => 'silly',
			));

		Tag::create(array(
			'tag' => 'absurd',
			'slug' => 'absurd',
			));

		Tag::create(array(
			'tag' => 'useless',
			'slug' => 'useless',
			));

		Tag::create(array(
			'tag' => 'tedious',
			'slug' => 'tedious',
			));
	}
}