<?php namespace Scrib\Repo\Tag;

interface TagInterface {

	/**
	 * Get tag by URL slug
	 * @param  string $slug slug URL
	 * @return object       Object with Tag information
	 */
	public function bySlug($slug);

	/**
	 * Find existing tags and create any new ones
	 * @param  array  strings representing tags
	 * @return array or collection of Tag objects       
	 */
	public function findOrCreate(array $tags);

	
	/**
	 * acces to many to many relation with articles
	 * @return object instance of Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function articles();
}