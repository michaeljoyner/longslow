<?php namespace Scrib\Service\Form\Category;

use Scrib\Repo\ContentImage\LaravelCategoryImage;
use Scrib\Service\Form\ValidatingForm;
use Scrib\Repo\Category\CategoryInterface;
use Scrib\Service\Validation\ValidableInterface;

class CreateCategoryForm extends ValidatingForm {

    protected $validator;
    protected $category;
    private $imageHandler;

    public function __construct(ValidableInterface $validator, CategoryInterface $category, LaravelCategoryImage $imageHandler)
    {
        $this->validator = $validator;
        $this->category = $category;
        $this->imageHandler = $imageHandler;
    }

    public function save($input)
    {
        if ( ! $this->valid($input))
        {
            return false;
        }

        $input = $this->storeImageAndSetPath($input);

        return $this->category->create($input);
    }

    public function update($input)
    {
        if ( ! $this->valid($input))
        {
            return false;
        }

        $input = $this->storeImageAndSetPath($input);

        return $this->category->update($input);
    }

    protected function storeImageAndSetPath($input)
    {
        if (isset($input['cover']))
        {
            $path = $this->imageHandler->store(array('image' => $input['cover']));
            $input['cover_path'] = $path;
        }

        if ( ! isset($path))
        {
            $input['cover_path'] = null;
            return $input;
        }
        return $input;
    }
} 