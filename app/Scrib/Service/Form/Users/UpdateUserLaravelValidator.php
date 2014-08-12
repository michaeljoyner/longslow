<?php namespace Scrib\Service\Form\Users;

use Scrib\Service\Validation\AbstractLaravelValidator;

class UpdateUserLaravelValidator extends AbstractLaravelValidator {

	protected $rules = array(
		'fullname' => 'required|max:255',
		'email' => 'required|max:255',
		'bio' => 'max:512'
	);

	protected $messages = array(
		'fullname.max' => 'Your name is too long! Try use less than 255 characters.',
		'fullname.required' => 'We need your name please',
		'email.required' => 'Please give an email address.',
		'email.max' => 'Your email address is too long (max 255 characters).',
		'bio.max' => 'Too long. Please keep it short and sweet, less than 512 characters.'
	);
}