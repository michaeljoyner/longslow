<?php

class CategoryTest extends TestCase {

	public function setUp() {
		parent::setUp();

		Artisan::call('migrate');
		Artisan::call('db:seed');

		$this->category = new \Scrib\Repo\Category\EloquentCategory( new Category );
	}

	public function testAllReturnsAllCategories() {
		$result = $this->category->all();
		$count = $result->count();

		$this->assertSame(4, $count);
	}

	public function testByIdReturnsCorrectCategory() {
		$result = $this->category->byId(1);

		$this->assertSame(1, $result->id);
	}

	public function testByIdReturnsNullForNonExistingId()
	{
		$result = $this->category->byId(8);

		$this->assertSame(NULL, $result);
	}

	public function testByCategoryReturnsCorrectCategory()
	{
		$result = $this->category->byCategory('sports');

		$this->assertSame('sports', $result->category);
	}

	public function testByCategoryReturnsNullForNonExistingCategory()
	{
		$result = $this->category->byCategory('jjjjj');

		$this->assertSame(NULL, $result);
	}


}