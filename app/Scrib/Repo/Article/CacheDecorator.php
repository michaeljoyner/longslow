<?php namespace Scrib\Repo\Article;

use Scrib\Service\Cache\CacheInterface;


class CacheDecorator extends AbstractArticleDecorator {

	protected $cache;

	public function __construct(ArticleInterface $nextArticle, CacheInterface $cache)
	{
		parent::__construct($nextArticle);
		$this->cache = $cache;
	}

	/**
	 * attempt to get article from cache by ID
	 * @param  int $id article ID
	 * @return object     Article
	 */
	public function byId($id)
	{
		$key = md5('id.'.$id);

		if( $this->cache->has($key) )
		{
			return $this->cache->get($key);
		}

		$article = $this->nextArticle->byId($id);

		$this->cache->put($key, $article);

		return $article;
	}


	public function bySlug($slug)
	{
		$key = md5('slug.'.$slug);

		if( $this->cache->has($key) )
		{
			return $this->cache->get($key);
		}

		$article = $this->nextArticle->bySlug($slug);

		$this->cache->put($key, $article);

		return $article;
	}

	public function byPage($page=1, $limit=10, $drafts=1, $useronly=false)
	{
		$key = md5('key.'.$page.'.'.$limit);

		if( $this->cache->has($key) )
		{
			return $this->cache->get($key);
		}

		$paginated = $this->nextArticle->byPage($page, $limit, $drafts, $useronly);

		$this->cache->put($key, $paginated);

		return $paginated;
	}

	public function byTag($tag, $page=1, $limit=10)
	{
		$key = md5('tag.'.$tag.'.'.$page.'.'.$limit);

		if( $this->cache->has($key) )
		{
			return $this->cache->get($key);
		}

		$paginated = $this->nextArticle->byTag($tag, $page, $limit);

		$this->cache->put($key, $paginated);

		return $paginated;
	}

	public function byCategory($category, $page=1, $limit=10)
	{
		$key = md5('category.'.$category.'.'.$page.'.'.$limit);

		if( $this->cache->has($key) )
		{
			return $this->cache->get($key);
		}

		$paginated = $this->nextArticle->byCategory($category, $page, $limit);

		$this->cache->put($key, $paginated);

		return $paginated;
	}

    public function getStats()
    {
        return $this->nextArticle->getStats();
    }
}