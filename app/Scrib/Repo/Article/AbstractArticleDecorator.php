<?php namespace Scrib\Repo\Article;

abstract class AbstractArticleDecorator implements ArticleInterface {

	protected $nextArticle;

	public function __construct(ArticleInterface $nextArticle)
	{
		$this->nextArticle = $nextArticle;
	}

	public function byId($id)
	{
		return $this->nextArticle->byId($id);
	}

	public function byPage($page=1, $limit=10, $drafts=1, $useronly=false)
	{
		return $this->nextArticle->byPage($page=1, $limit=10, $drafts=1, $useronly=false);
	}

	public function bySlug($slug)
	{
		return $this->nextArticle->bySlug($slug);
	}

	public function byTag($tag, $page=1, $limit=10)
	{
		return $this->nextArticle->byTag($tag, $page=1, $limit=10);
	}

	public function byCategory($category, $page=1, $limit=10)
	{
		return $this->nextArticle->byCategory($category, $page=1, $limit=10);
	}

	public function create(array $data)
	{
		return $this->nextArticle->create($data);
	}

	public function update(array $data)
	{
		return $this->nextArticle->update($data);
	}

    public function destroy($id)
    {
        return $this->nextArticle->destroy($id);
    }
}