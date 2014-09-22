<?php namespace Scrib\Repo;

class RepoAbstract {

	/**
	 * Makes a url friendly slug from given string
	 * @param  string $string Human-friendly
	 * @return string         Computer friendly tag/slug
	 */
	protected function slug($title, $model)
	{
        $slug = \Str::slug($title);
        $slugCount = count($model->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get());

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
	}
}