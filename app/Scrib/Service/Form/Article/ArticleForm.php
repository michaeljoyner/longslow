<?php namespace Scrib\Service\Form\Article;

use Scrib\Service\Form\ValidatingForm;
use Scrib\Service\Validation\ValidableInterface;
use Scrib\Repo\Article\ArticleInterface;
use Scrib\Repo\ContentImage\ImageInterface;

class ArticleForm extends ValidatingForm {

	/**
	 * Form data
	 * @var Array
	 */
	protected $data;

	/**
	 * Validator
	 * @var Scrib\Service\Validation\ValidableInterface
	 */
	protected $validator;

	/**
	 * Article repository
	 * @var Scrib\Repo\Article\ArticleInterface
	 */
	protected $article;

	public function __construct(ValidableInterface $validator, ArticleInterface $article, ImageInterface $cover)
	{
		$this->validator = $validator;
		$this->article = $article;
		$this->cover = $cover;
	}

	/**
	 * Create a new article
	 * @param  array  $input 
	 * @return bool        
	 */
	public function save(array $input)
	{
		if( ! $this->valid($input) )
		{
			return false;
		}
		if( isset($input['cover_pic']) )
		{
			$id = $this->setCoverImage($input['cover_pic']);
			$input = array_merge($input, array('cover_id' => $id));

		}
		return $this->article->create($input);
	}

	/**
	 * Update an existing article
	 * @param  array  $input 
	 * @return bool        
	 */
	public function update(array $input)
	{
		if( ! $this->valid($input) )
		{
			return false;
		}
		if( isset($input['cover_pic']) )
		{
			$id = $this->setCoverImage($input['cover_pic']);
			$input = array_merge($input, array('cover_id' => $id));
		}

		return $this->article->update($input);
	}



	protected function setCoverImage($image)
	{
		$data = array('image' => $image);
		return $this->cover->store($data);		
	}


}