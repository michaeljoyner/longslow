<?php namespace Scrib\Repo;

use Article; //Eloquent article
use Tag;
use Category;
use Status;
use User;
use Author;
use Scrib\Service\Cache\LaravelCache;
use Scrib\Repo\Article\CacheDecorator;
use Scrib\Repo\Tag\EloquentTag;
use Scrib\Repo\Article\EloquentArticle;
use Scrib\Repo\Category\EloquentCategory;
use Scrib\Repo\Status\EloquentStatus;
use Scrib\Repo\User\EloquentUserModel;
use Scrib\Repo\Author\EloquentAuthor;
use Illuminate\Support\ServiceProvider;
use Scrib\Repo\ContentImage\LaravelContentImage;
use Intervention\Image\ImageManager;

class RepoServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 * @return void 
	 */
	public function register() {

		$app = $this->app;

		$app->bind('Scrib\Repo\Tag\TagInterface', function($app) {
			return new EloquentTag( new Tag );
		});

		$app->bind('Scrib\Repo\Article\ArticleInterface', function($app) {
			$article = new EloquentArticle( new Article, $app->make('Scrib\Repo\Tag\TagInterface'), $app->make('Scrib\Repo\Category\CategoryInterface'));

//			if( $app->env !== 'local' )
//			{
//				$article = new CacheDecorator( $article, new LaravelCache($app['cache'], 'articles', 10));
//			}

			return $article;
		});

		$app->bind('Scrib\Repo\Category\CategoryInterface', function($app) {
			return new EloquentCategory( new Category );
		});

		$app->bind('Scrib\Repo\Status\StatusInterface', function($app) {
			return new EloquentStatus( new Status );
		});

		$app->bind('Scrib\Repo\ContentImage\ImageInterface', function($app) {
			return new LaravelContentImage( new ImageManager );
		});

		$app->bind('Scrib\Repo\User\UserModelInterface', function($app) {
			return new EloquentUserModel( new User, $app['hash'] );
		});

		$app->bind('Scrib\Repo\Author\AuthorInterface', function($app) {
			return new EloquentAuthor( new Author );
		});
	}
}