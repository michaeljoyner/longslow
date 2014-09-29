<?php namespace Scrib\Repo\Article;

use Auth;
use Scrib\Repo\Tag\TagInterface;
use Scrib\Repo\Category\CategoryInterface;
use Illuminate\Database\Eloquent\Model;
use Scrib\Repo\RepoAbstract;
use StdClass;

class EloquentArticle extends RepoAbstract implements ArticleInterface {

    protected $article;
    protected $tag;
    protected $category;

    //Class dependancy: Eloquent model and implementation of TagInterface
    public function __construct(Model $article, TagInterface $tag, CategoryInterface $category)
    {
        $this->article = $article;
        $this->tag = $tag;
        $this->category = $category;
    }

    public function byId($id)
    {
        return $this->article->with('tags', 'category', 'cover', 'author.author')
                             ->where('id', $id)
                             ->first();
    }

    /**
     * Get paginated articles
     * @param  integer $page Current page
     * @param  integer $limit Number of articles per page
     * @param int $drafts flag to include or return only drafts
     * @param bool $useronly show only users posts
     * @return StdClass         Object with $itmes and $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, $drafts = 1, $useronly=false)
    {
        $result = new StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->article->with('tags', 'category', 'cover', 'author.author');
        if ($drafts == 0)
        {
            $query->where('status_id', 1);
        }
        else
        {
            if ($drafts == 2)
            {
                $query->where('status_id', 2);
            }
        }
        if($useronly)
        {
            $query->where('user_id', \Auth::user()->id);
        }
        $articles = $query->orderBy('updated_at', 'desc')
                          ->skip($limit * ($page - 1))
                          ->take($limit)
                          ->get();

        //Create object to return data useful for pagination
        $result->items = $articles->all();
        switch($drafts) {
            case 0:
                $result->totalItems = $this->totalArticles();
                break;
            case 1:
                $result->totalItems = $this->totalArticlesAll();
                break;
            case 2:
                $result->totalItems = $this->totalDrafts();
                break;
            default:
                $result->totalItems = $this->totalArticles();
        }
        if($useronly)
        {
            $result->totalItems = $this->totalByCurrentUser();
        }

        return $result;
    }

    /**
     * Get single article by URL
     * @param  string $slug slug of article
     * @return object       Object with article information
     */
    public function bySlug($slug)
    {
        return $this->article->with('tags', 'category', 'cover', 'author.author')
                             ->where('status_id', 1)
                             ->where('slug', $slug)
                             ->first();
    }

    /**
     * Get articles with given tag
     * @param  string $tag string representing tag
     * @param  integer $page Current page
     * @param  integer $limit Number of articles per page
     * @return object         Object with article and pagination info
     */
    public function byTag($tag, $page = 1, $limit = 10)
    {
        $foundTag = $this->tag->bySlug($tag);

        $result = new StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        if ( ! $foundTag)
        {
            return $result;
        }

        $articles = $this->tag->bySlug($tag)
                              ->articles()
                              ->with('author.author')
                              ->with('tags')
                              ->with('category')
                              ->with('cover')
                              ->where('articles.status_id', 1)
                              ->orderBy('articles.created_at', 'desc')
                              ->skip($limit * ($page - 1))
                              ->take($limit)
                              ->get();

        $result->totalItems = $this->totalByTag($tag);
        $result->items = $articles->all();

        return $result;
    }


    public function byCategory($category, $page = 1, $limit = 10)
    {
        $foundCategory = $this->category->byCategory($category)->first();

        $result = new StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        if ( ! $foundCategory)
        {
            return $result;
        }

        $articles = $this->category->byCategory($category)
                                   ->articles()
                                   ->with('author.author')
                                   ->with('category')
                                   ->with('tags')
                                   ->with('status')
                                   ->with('cover')
                                   ->where('articles.status_id', 1)
                                   ->orderBy('articles.created_at', 'desc')
                                   ->skip($limit * ($page - 1))
                                   ->take($limit)
                                   ->get();

        $result->totalItems = $this->totalByCategory($category);
        $result->items = $articles->all();

        return $result;
    }

    /**
     * Create a new article
     * @param  array $data Data to create new article
     * @return bool
     */
    public function create(array $data)
    {
        $article = $this->article->create(array(
            'user_id'     => $data['user_id'],
            'status_id'   => $data['status_id'],
            'category_id' => $data['category_id'],
            'title'       => $data['title'],
            'slug'        => $this->slug($data['title'], $this->article),
            'excerpt'     => $data['excerpt'],
            'content'     => $data['content'],
            'cover_id'    => isset($data['cover_id']) ? $data['cover_id'] : null
        ));

        if ( ! $article)
        {
            return false;
        }

        $tags = $this->createTagArray($data['tags']);

        $this->syncTags($article, $tags);

        return true;
    }

    /**
     * Update an existing article
     * @param  array $data Data to update
     * @return bool
     */
    public function update(array $data)
    {
        $article = $this->article->find($data['id']);

        if ( ! $article)
        {
            return false;
        }

        if ($data['status_id'] === '3')
        {
            $article->timestamps = false;
            $data['status_id'] = 1;
        }
        //note user_id is not updated, as someone other than the original author may edit
        $article->status_id = $data['status_id'];
        $article->category_id = $data['category_id'];
        $article->title = $data['title'];
//        $article->slug = $this->slug($data['title'], $this->article);
        $article->excerpt = $data['excerpt'];
        $article->content = $data['content'];

        if (isset($data['cover_id']))
        {
            $article->cover_id = $data['cover_id'];
        }

        $article->save();

        $tags = $this->createTagArray($data['tags']);

        $this->syncTags($article, $tags);

        return true;
    }

    public function destroy($id)
    {
        $article = $this->article->find($id);
        return $article->delete();
    }

    public function getStats()
    {
        $stats = new StdClass;
        $stats->published = $this->totalArticles();
        $stats->drafts = $this->totalDrafts();
        $stats->byUser = $this->totalByCurrentUser();

        return $stats;
    }

    /**
     * Sync tags for article
     * @param  \Illuminate\Database\Eloquent\Model $article
     * @param  array $tags
     * @return void
     */
    protected function syncTags(Model $article, array $tags)
    {
        $tags = $this->tag->findOrCreate($tags);

        $tagIds = array();

        foreach ($tags as $tag)
        {
            $tagIds[] = $tag->id;
        }

        $article->tags()->sync($tagIds);
    }

    /**
     * Get total article count
     * @return integer Total articles
     */
    protected function totalArticles()
    {
        return $this->article->where('status_id', 1)->count();
    }

    protected function totalArticlesAll()
    {
        return $this->article->count();
    }

    /**
     * Get total articles count per tag
     * @param  string $tag Tag slug
     * @return integer      Total articles per tag
     */
    protected function totalByTag($tag)
    {
        return $this->tag->bySlug($tag)
                         ->articles()
                         ->where('status_id', 1)
                         ->count();
    }

    /**
     * Get total article count by category
     * @param  string $category category name
     * @return integer           Total number of articles with that category
     */
    protected function totalByCategory($category)
    {
        return $this->category->byCategory($category)
                              ->articles()
                              ->where('status_id', 1)
                              ->count();
    }

    protected function totalDrafts()
    {
        return $this->article->where('status_id', 2)->count();
    }

    protected function totalByCurrentUser()
    {
        $userId = Auth::user()->id;
        return $this->article->where('user_id', $userId)->count();
    }

    protected function createTagArray($tagString)
    {
        $tagString = $tagString === '' ? 'general' : $tagString;
        $tagArray = explode(',', $tagString);
        $tags = array();
        foreach ($tagArray as $tag)
        {
            $tags[] = trim($tag);
        }
        return $tags;
    }


}