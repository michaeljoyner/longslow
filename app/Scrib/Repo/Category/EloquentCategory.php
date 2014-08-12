<?php namespace Scrib\Repo\Category;

use Illuminate\Database\Eloquent\Model;
use Scrib\Repo\RepoAbstract;

class EloquentCategory extends RepoAbstract implements CategoryInterface {

    protected $category;

    public function __construct(Model $category)
    {
        $this->category = $category;
    }

    /**
     * get all categories
     * @return array Collection of Category objects
     */
    public function all()
    {
        return $this->category->all();
    }

    /**
     * get category by Id
     * @param  int $id category Id
     * @return object     Category object
     */
    public function byId($id)
    {
        return $this->category->find($id);
    }

    /**
     * get category by slug
     * @param  string $category category slug
     * @return object           Category object
     */
    public function byCategory($category)
    {
        return $this->category->where('category', $category)->first();
    }


    public function create($data)
    {
        $category = $this->category->create(array(
                'category'    => $data['category'],
                'slug'        => $this->slug($data['category']),
                'description' => $data['description'],
                'cover'       => $data['cover_path']
            )
        );

        if ( ! $category)
        {
            return false;
        }

        return true;
    }

    public function update($data)
    {
        $category = $this->category->find($data['id']);

        if ( ! $category)
        {
            return false;
        }

        $category->category = $data['category'];
        $category->slug = $this->slug($data['category']);
        $category->description = $data['description'];
        if ( ! empty($data['cover_path']))
        {
            $category->cover = $data['cover_path'];
        }
        $category->save();

        return true;
    }
}