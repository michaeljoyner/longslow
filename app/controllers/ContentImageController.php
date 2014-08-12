<?php

use Scrib\Service\Form\Article\ArticleImageForm;

class ContentImageController extends BaseController {

	protected $form;

	public function __construct(ArticleImageForm $articleImageForm)
	{
		$this->form = $articleImageForm;
	}

	public function store()
	{
		$input = array('image' => Input::file('image'));

		$savePath = $this->form->save( $input );

		if( ! $savePath )
		{
			return Response::make($this->form->errors()->first('image'), 400);
		}

		return Response::make(url($savePath), 200);
	}
}