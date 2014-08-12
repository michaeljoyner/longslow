<?php

use Scrib\Service\Form\Article\ArticleForm;
use Scrib\Repo\Article\ArticleInterface;
use Scrib\Repo\Category\CategoryInterface;

class ArticleController extends \BaseController {

	protected $form;
	protected $article;
	protected $category;

	public function __construct(ArticleForm $form, ArticleInterface $article, CategoryInterface $category)
	{
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
		$this->form = $form;
		$this->category = $category;
		$this->article = $article;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$page = Input::get('page', 1);

		$pagiData = $this->article->byPage($page);

		$articles = Paginator::make($pagiData->items, $pagiData->totalItems, 10);

		return View::make('admin.content')->with('articles', $articles);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$categories = $this->category->all();
		return View::make('admin.create')->with('categories', $categories);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$added = array(
			'cover_pic' => Input::file('cover_pic'),
			'user_id' => Auth::user()->id
		);

		$input = array_merge(Input::all(), $added);
		
		if( $this->form->save($input) )
		{
			return Redirect::route('admin.article.index');
		} else {
			return Redirect::route('admin.article.create')->withErrors( $this->form->errors() )->withInput();
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->edit($id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$article = $this->article->byId($id);
		$categories = $this->category->all();

		$tags = '';

		foreach ($article->tags as $tag) {
			$tags .= ' ,'.$tag->tag;
		}

		$tags = substr($tags, 2);

		return View::make('admin.edit')->with(array('article' => $article, 'categories' => $categories, 'tags' => $tags));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$added = array('id' => $id, 'user_id' => Auth::user()->id);
		$input = array_merge(Input::all(), $added);
		if( Input::hasFile('cover_pic') )
		{
			$img = array('cover_pic' => Input::file('cover_pic'));
			$input = array_merge($input, $img);
		}

		if( $this->form->update($input) )
		{
			return Redirect::route('admin.article')->with('flash_message', 'Post updated successfully');
		}
		else
		{
			return Redirect::route('admin.article.edit', $id)->withErrors( $this->form->errors() )->withInput();
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$article = $this->article->byId($id);

		if( ! $article )
		{
			return Response::make('article not found on server', 404);	
		}

		if( ! $article->userCanModify(Auth::user()) )
		{
			return Response::make('user does not have permission', 401);
		}

		return Response::make('deleting article '.$id, 200);
	}


}
