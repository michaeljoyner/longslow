<?php

class Role extends Eloquent {

	protected $table = 'roles';
	protected $fillable = array('role_name', 'description');

	public function users()
	{
		return $this->hasMany('User');
	}
}