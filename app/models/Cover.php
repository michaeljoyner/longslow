<?php

class Cover extends Eloquent {

	protected $table = 'covers';

	protected $fillable = array('path');

	public function articles()
	{
		return $this->hasMany('Article');
	}
}