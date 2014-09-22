<?php namespace Scrib\Repo\Article; 

interface ArticleInterface {

	/**
	 * getsingle article by Id
	 * @param  integer $id 
	 * @return object     Article Model
	 */
	public function byId($id);

    /**
     * Get paginated articles
     * @param  integer $page Current Page
     * @param  integer $limit No of articles per page
     * @param int $drafts flag to include or return only drafts
     * @param bool $useronly show only users posts
     * @return object         Object with $items and $totalItems for pagination
     */
	public function byPage($page=1, $limit=10, $drafts = 1, $useronly=false);

	/**
	 * Get single article by url
	 * @param  srting $slug slug of article
	 * @return object       Object of article information
	 */
	public function bySlug($slug);

	/**
	 * Get articles by their tag
	 * @param  string  $tag   URL slug of tag
	 * @param  integer $page  Current page
	 * @param  integer $limit Number of articles per page
	 * @return object         Object with $items and $totalItems for pagination
	 */
	public function byTag($tag, $page=1, $limit=10);

	/**
	 * Gets articles by category
	 * @param  string  $category category name
	 * @param  integer $page     Current page
	 * @param  integer $limit    Number of articles per page
	 * @return object            Object with $items and $totalItems for pagination
	 */
	public function byCategory($category, $page=1, $limit=10);

	/**
	 * Create a new article
	 * @param  array  $data 
	 * @return bool       
	 */
	public function create(array $data);

	/**
	 * Update an existing article
	 * @param  array  $data 
	 * @return bool       
	 */
	public function update(array $data);

	/**
	 * Delete an article from the db
	 * @param  int $id Article id
	 * @return bool     
	 */
	public function destroy($id);
}