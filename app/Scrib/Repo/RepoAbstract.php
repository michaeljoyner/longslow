<?php namespace Scrib\Repo;

class RepoAbstract {

	/**
	 * Makes a url friendly slug from given string
	 * @param  string $string Human-friendly
	 * @return string         Computer friendly tag/slug
	 */
	protected function slug($string)
	{
		return filter_var( str_replace(' ', '-', strtolower( trim($string) ) ), FILTER_SANITIZE_URL);
	}
}