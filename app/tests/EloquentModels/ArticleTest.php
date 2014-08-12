<?php

class ArticleTest extends TestCase {

	public function setUp() {
		parent::setUp();

		// Tag::truncate();
		// Article::truncate();
		// Status::truncate();
		// Category::truncate();
		Artisan::call('migrate');
		Artisan::call('db:seed');

		$this->tag = new \Scrib\Repo\Tag\EloquentTag( new Tag );
		$this->category = new \Scrib\Repo\Category\EloquentCategory( new Category );
		$this->article = new \Scrib\Repo\Article\EloquentArticle( new Article, $this->tag, $this->category );
	}

	public function testGetTotalArticles() {
		
		$result = $this->article->byPage();
		$count = $result->totalItems;
		// $count = count($result->items);

		$this->assertEquals($count, 4);
	}

	public function testByPageReturnsObjectWithItemsAsArray()
	{
		$result = $this->article->byPage();
		$this->assertInternalType('array', $result->items);
	}

	public function testByPageReturnsNoMoreThanLimit()
	{
		$result = $this->article->byPage(1,3);
		$articleCount = count($result->items);
		$this->assertTrue(3 >= $articleCount);
	}

	public function testByTagOnlyReturnsArticlesWithTag() {
		$result = $this->article->byTag('silly');
		$cond = true;
		$found;
		foreach ($result->items as $item) {
			foreach ($item->tags->all() as $tags) {
				$found = false;
				if( !$found && $tags->slug === 'silly') {
					$found = true;
					break;
				}
			}
			if( !$found ) {
				$cond = false;
				break;
			}
		}
		
		$this->assertTrue($cond);
	}

	public function testByTagReturnsObjectWithCorrectTotalItems()
	{
		$result = $this->article->byTag('useless');
		$articleCount = $result->totalItems;

		$this->assertSame(2, $articleCount);
	}

	public function testByTagReturnsObjectWithItemsAsEmptyArrayIfNoneFound()
	{
		$result = $this->article->byTag('jjjjjj');
		$this->assertInternalType('array', $result->items);
		$this->assertTrue(empty($result->items));
	}

	public function testbySlugGetsOnlyArticlesWithSlug() {
		$result = $this->article->bySlug('my-first-article');
		$articleSlug = $result->slug;

		$this->assertEquals('my-first-article', $articleSlug);
	}

	public function testbySlugReturnsNullIfSlugNotFound()
	{
		$result = $this->article->bySlug('jjjjjjjjj');

		$this->assertSame(NULL, $result);
	}

	public function testbyCategoryReturnsOnlyArticlesWithCorrectCategory()
	{
		$result = $this->article->byCategory('sports');
		$cond = true;

		foreach ($result->items as $article) {
			if($article->category->category !== 'sports') {
				$cond = false;
				break;
			}
		}

		$this->assertTrue($cond);
	}

	public function testByCategoryReturnsCorrectAmountOfArticles()
	{
		$result = $this->article->byCategory('news');
		$articleCount = count($result->items);

		$this->assertSame(1, $articleCount);
	}

	public function testbyCategoryReturnsCorrectTotalItems()
	{
		$result = $this->article->byCategory('business');
		$articleCount = $result->totalItems;

		$this->assertSame(1, $articleCount);
	}
}