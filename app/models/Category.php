<?php

class Category extends Eloquent {

	/**
	 * database table name
	 * @var string
	 */
	protected $table = 'categories';

	/**
	 * mass assignable attributes
	 * @var array
	 */
	protected $fillable = array(
		'category',
		'slug',
        'description',
        'cover'
	);

	/**
	 * one to many relationship with articles
	 * @return \Illuminate\Database\Eloquent\Relationships\HasMany
	 */
	public function articles()
	{
		return $this->hasMany('Article');
	}
}