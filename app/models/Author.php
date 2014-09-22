<?php

class Author extends Eloquent {

	protected $table = 'authors';
	protected $fillable = array('fullname', 'slug', 'bio', 'user_id', 'profilepic');

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function getImageSrc()
	{
		if( ! $this->profilepic || ! file_exists(public_path().$this->profilepic) )
		{
			return '/images/blankuser.png';
		}
		else {
			return $this->profilepic;
		}
	}
}