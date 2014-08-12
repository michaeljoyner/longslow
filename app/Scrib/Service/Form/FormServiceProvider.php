<?php namespace Scrib\Service\Form;

use Cover;
use Illuminate\Support\ServiceProvider;
use Scrib\Repo\ContentImage\LaravelCategoryImage;
use Scrib\Service\Form\Article\ArticleForm;
use Scrib\Service\Form\Article\ArticleFormLaravelValidator;
use Scrib\Service\Form\Article\ArticleImageForm;
use Scrib\Service\Form\Article\ArticleImageLaravelValidator;
use Scrib\Repo\ContentImage\LaravelCoverImage;
use Scrib\Service\Form\Users\CreateUserForm;
use Scrib\Service\Form\Users\UpdateUserForm;
use Scrib\Service\Form\Users\UpdateUserRoleForm;
use Scrib\Service\Form\Users\ResetUserPasswordForm;
use Scrib\Service\Form\Category\CreateCategoryForm;
use Scrib\Service\Form\Users\CreateUserLaravelValidator;
use Scrib\Service\Form\Users\UpdateUserLaravelValidator;
use Scrib\Service\Form\Users\UpdateUserRoleLaravelValidator;
use Scrib\Service\Form\Users\ResetPasswordLaravelValidator;
use Scrib\Service\Form\Category\CreateCategoryLaravelValidator;
use Intervention\Image\ImageManager;

class FormServiceProvider extends ServiceProvider {

	public function register()
	{
		$app = $this->app;

		$app->bind('Scrib\Service\Form\Article\ArticleForm', function($app)
		{
			return new ArticleForm(
				new ArticleFormLaravelValidator( $app['validator'] ),
				$app->make('Scrib\Repo\Article\ArticleInterface'),
				new LaravelCoverImage(new Cover, new ImageManager )
			);
		});

		$app->bind('Scrib\Service\Form\Article\ArticleImageForm', function($app)
		{
			return new ArticleImageForm(
				new ArticleImageLaravelValidator( $app['validator'] ),
				$app->make('Scrib\Repo\ContentImage\ImageInterface')
			);
		});

		$app->bind('Scrib\Service\Form\Users\CreateUserForm', function($app)
		{
			return new CreateUserForm(
				new CreateUserLaravelValidator( $app['validator'] ),
				$app->make('Scrib\Repo\User\UserModelInterface'),
				$app->make('Scrib\Repo\Author\AuthorInterface')
			);
		});

		$app->bind('Scrib\Service\Form\Users\UpdateUserForm', function($app)
		{
			return new UpdateUserForm(
				new UpdateUserLaravelValidator( $app['validator'] ),
				$app->make('Scrib\Repo\User\UserModelInterface'),
				$app->make('Scrib\Repo\Author\AuthorInterface')
			);
		});

        $app->bind('Scrib\Service\Form\Users\UpdateUserRoleForm', function($app)
        {
            return new UpdateUserRoleForm(
                new UpdateUserRoleLaravelValidator( $app['validator'] ),
                $app->make('Scrib\Repo\User\UserModelInterface')
            );
        });

        $app->bind('Scrib\Service\Form\Users\ResetUserPasswordForm', function($app)
        {
            return new ResetUserPasswordForm(
                new ResetPasswordLaravelValidator( $app['validator'] ),
                $app->make('Scrib\Repo\User\UserModelInterface')
            );
        });

        $app->bind('Scrib\Service\Form\Category\CreateCategoryForm', function($app)
        {
            return new CreateCategoryForm(
                new CreateCategoryLaravelValidator( $app['validator'] ),
                $app->make('Scrib\Repo\Category\CategoryInterface'),
                new LaravelCategoryImage(new ImageManager())
            );
        });

    }
}