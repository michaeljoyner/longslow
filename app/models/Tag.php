<?php

class Tag extends Eloquent {

	/**
	 * database table name
	 * @var string
	 */
	protected $table = 'tags';

	/**
	 * mass assignable attributes
	 * @var array
	 */
	protected $fillable = array(
		'tag',
		'slug'
	);

	public $timestamps = false;

	/**
	 * many to many relationship with Article
	 * @return \Illuminate\Database\Eloquent\Relationships\BelongsToMany
	 */
	public function articles() {
		return $this->belongsToMany('Article', 'articles_tags', 'tag_id', 'article_id');
	}
}