<?php namespace Scrib\Repo\ContentImage;

interface ImageInterface {

	/**
	 * store image on filesystem
	 * @param  file $image 
	 * @return string        real path to stored image
	 */
	public function store($image);

	/**
	 * Retrieves image from filesystem
	 * @param  string $path path to image
	 * @return file       image
	 */
	public function get($path);
}