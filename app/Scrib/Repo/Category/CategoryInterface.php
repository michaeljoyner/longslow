<?php namespace Scrib\Repo\Category;

interface CategoryInterface {

	/**
	 * get all categories
	 * @return array  Collection of categories
	 */
	public function all(); 

	/**
	 * get category by ID
	 * @param  int $id Category ID
	 * @return object     Category object
	 */
	public function byId($id);

	/**
	 * get category by category string
	 * @param  string $category Category slug
	 * @return object           Category object
	 */
	public function byCategory($category);

	/**
	 * create a new category
	 * @param  array data to create
	 * @return bool     return true on success, false on failure
	 */
	public function create($input);

    public function update($input);
}