<?php namespace Scrib\Repo\Tag;

use Illuminate\Database\Eloquent\Model;
use Scrib\Repo\RepoAbstract;

class EloquentTag extends RepoAbstract implements TagInterface {

	protected $tag;

	public function __construct(Model $tag) {
		$this->tag = $tag;
	}

	/**
	 * find tag by slug URL
	 * @param  string $slug slug of Tag to search for
	 * @return object       Object with Tag information
	 */
	public function bySlug($slug) {
		return $this->tag->where('slug', $slug)->first();
	}

	/**
	 * find existing Tags or create new ones
	 * @param  array  $tags array of strings reperesenting tags
	 * @return array or collection       Array of Tag objects
	 */
	public function findOrCreate(array $tags) {
		$foundTags = $this->tag->whereIn('tag', $tags)->get();

		$returnTags = array();

		if( $foundTags ) {
			foreach ($foundTags as $tag) {
				$pos = array_search($tag->tag, $tags);
				if( $pos !== false ) {
					$returnTags[] = $tag;
					unset($tags[$pos]);
				}
			}
		}

		foreach ($tags as $tag) {
			$returnTags[] = $this->tag->create(array(
										'tag' => $tag,
										'slug' => $this->slug($tag, $this->tag),
									));
		}

		return $returnTags;
	}

	/**
	 * returns articles query for tag model
	 * @return object instance of Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */ 
	public function articles() {
		return $this->tag->articles();
	}
}