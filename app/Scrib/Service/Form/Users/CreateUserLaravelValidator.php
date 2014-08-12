<?php namespace Scrib\Service\Form\Users;

use Scrib\Service\Validation\AbstractLaravelValidator;

class CreateUserlaravelValidator extends AbstractLaravelValidator {

	protected $rules = array(
		'email' => 'required|email',
		'password' => 'required|min:8|confirmed',
		'fullname' => 'required|max:255',
		'role_id' => 'required|integer|in:1,2,3'
	);

	protected $messages = array(
		'password.confirmed' => 'Passwords don\'t match, please make sure you typed the passwords correctly.',
		'role_id.in' => 'Please select a role for the new user' 
	);
}