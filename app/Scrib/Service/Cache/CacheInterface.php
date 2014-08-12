<?php namespace Scrib\Service\Cache;

interface CacheInterface {

	/**
	 * Retrieve data from cache
	 * @param  string $key Cache item key
	 * @return mixed      PHP dada result of cache
	 */
	public function get($key);

	/**
	 * Add data to cache
	 * @param  string $key     Cache item key
	 * @param  mixed $value   data to store
	 * @param  int $minutes Number of minutes to store item
	 * @return mixed          Value saved into cache
	 */
	public function put($key, $value, $minutes = null);

	/**
	 * Test if item exists in cache
	 * @param  string  $key Cache item key
	 * @return boolean      Cache item exists
	 */
	public function has($key);
}