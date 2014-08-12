<?php namespace Scrib\Service\Form\Users;

use Scrib\Service\Validation\ValidableInterface;
use Scrib\Repo\User\UserModelInterface;
use Scrib\Repo\Author\AuthorInterface;
use Scrib\Service\Form\ValidatingForm;

class CreateUserForm extends ValidatingForm {

	protected $validator;
	protected $user;
	protected $author;

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

		$created_user = $this->user->create($input);

		if( $created_user )
		{
			$author_data = array(
				'fullname' => $input['fullname'],
				'bio' => '',
				'user_id' => $created_user
			);

			$this->author->create($author_data);

			return true;
		}

		return false;
	}


}