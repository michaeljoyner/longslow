<?php

use Scrib\Repo\Article\ArticleInterface;
use Scrib\Repo\Category\CategoryInterface;

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	public function __construct(ArticleInterface $article, CategoryInterface $catgory)
	{
		$this->article = $article;
		$this->catgory = $catgory;
	}

	public function showWelcome()
	{
		$pagiData = $this->article->byPage();
		$articles = Paginator::make($pagiData->items, $pagiData->totalItems, 10);
		return View::make('hello')->with('articles', $articles);
	}

	public function showArticle($slug)
	{
		$article = $this->article->bySlug($slug);
		return View::make('single')->with('article', $article);
	}

}
