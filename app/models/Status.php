<?php

class Status extends Eloquent {

	/**
	 * database table name
	 * @var string
	 */
	protected $table = 'statuses';

	/**
	 * mass assignable attributes
	 * @var array
	 */
	protected $fillable = array(
		'status',
		'slug'
	);
}