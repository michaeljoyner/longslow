<?php namespace Scrib\Service\Form\Article;

use Scrib\Service\Validation\AbstractLaravelValidator;

class ArticleFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 * @var array
	 */
	protected $rules = array(
		'title' => 'required',
		'status_id' => 'required|in:1,2,3',
		'category_id' => 'required|exists:categories,id',
		'excerpt' => 'required',
		'content' => 'required',
		'tags' => 'max:255',
		'cover_pic' => 'mimes:jpg,png,gif,jpeg|max:5242880'
	);

	/**
	 * Validation custom error messages
	 * @var array
	 */
	protected $messages = array(
		'user_id.exists' => 'That user does not exist',
		'status_id.exists' => 'That status does not exist',
		'category_id.exists' => 'That category does not exist'
	);
}