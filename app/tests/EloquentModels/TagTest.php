<?php

class TagTest extends TestCase {

	public function setUp() {
		parent::setUp();

		Artisan::call('migrate');
		Artisan::call('db:seed');

		$this->tag = new \Scrib\Repo\Tag\EloquentTag( new Tag );
	}

	public function testFindOrCreateReturnsAllFoundTags() {
		$tags = array('silly', 'absurd', 'useless', 'tedious');

		$result = $this->tag->findOrCreate($tags);

		if( $result ) {
			foreach ($result as $tag) {
				$pos = array_search($tag->tag, $tags);
				if( $pos !== false ) {
					unset($tags[$pos]);
				}
			}
		}

		$this->assertTrue(empty($tags));
	}

	public function testFindOrCreateCreatesNewTags() {
		$tags = array('silly', 'foo', 'bar');

		$result = $this->tag->findOrCreate($tags);

		$foundFoo = false;
		$foundBar = false;

		foreach ($result as $tag) {
			if($tag->tag === 'foo') {
				$foundFoo = true;
				break;
			}
		}

		foreach ($result as $tag) {
			if($tag->tag === 'bar') {
				$foundBar = true;
				break;
			}
		}

		$this->assertTrue($foundBar && $foundFoo);
	}
}