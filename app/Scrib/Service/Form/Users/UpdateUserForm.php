<?php namespace Scrib\Service\Form\Users;

use Scrib\Service\Validation\ValidableInterface;
use Scrib\Repo\User\UserModelInterface;
use Scrib\Repo\Author\AuthorInterface;

class UpdateUserForm {

	protected $user;
	protected $author;
	protected $validator;

	public function __construct(ValidableInterface $validator, UserModelInterface $user, AuthorInterface $author)
	{
		$this->validator = $validator;
		$this->user = $user;
		$this->author = $author;
	}

	public function save($input)
	{
		if( ! $this->valid($input) )
		{
			return false;
		}

		$this->user->updateEmail($input['id'], $input['email']);

		$this->author->update($input['id'], $input);

		return true;
	}

	/**
	 * Return any validation errors
	 * @return array 
	 */
	public function errors()
	{
		return $this->validator->errors();
	}

	/**
	 * helper to Test if validation passes
	 * @param  array  $input 
	 * @return bool        
	 */
	protected function valid(array $input)
	{
		return $this->validator->with($input)->passes();
	}
}