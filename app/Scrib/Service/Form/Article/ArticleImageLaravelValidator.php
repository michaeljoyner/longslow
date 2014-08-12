<?php namespace Scrib\Service\Form\Article;

use Scrib\Service\Validation\AbstractLaravelValidator;

class ArticleImageLaravelValidator extends AbstractLaravelValidator {

	protected $rules = array(
		'image'=>'required|mimes:jpg,png,gif,jpeg|max:5242880'
	);


	protected $messages = array(
		'image.mimes' => 'Invalid file type. Please use jpg, png or gif',
		'image.max' => 'That file is too large. Please keep it under 5MB'
	);
}