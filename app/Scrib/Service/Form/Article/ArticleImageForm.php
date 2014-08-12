<?php namespace Scrib\Service\Form\Article;

use Scrib\Service\Form\ValidatingForm;
use Scrib\Service\Validation\ValidableInterface;
use Scrib\Repo\ContentImage\ImageInterface;

class ArticleImageForm extends ValidatingForm {

	protected $validator;
	protected $contentImage;

	public function __construct(ValidableInterface $validator, ImageInterface $contentImage)
	{
		$this->validator = $validator;
		$this->contentImage = $contentImage;
	}

	public function save(array $input)
	{
		if( !$this->valid($input) )
		{
			return false;
		}

		return $this->contentImage->store($input);
	}


}