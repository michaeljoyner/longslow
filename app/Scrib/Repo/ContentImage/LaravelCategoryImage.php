<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/1/2014
 * Time: 10:32 AM
 */

namespace Scrib\Repo\ContentImage;


use Intervention\Image\ImageManager;

class LaravelCategoryImage extends AbstractImage {
    protected $BASE_FOLDER = 'category_pic';
    protected $MAX_WIDTH = 800;
    protected $MAX_HEIGHT = 600;
    private $imageFactory;

    public function __construct(ImageManager $imageFactory)
    {
        $this->imageFactory = $imageFactory;
    }

    public function store($data)
    {
        $path = $this->getFinalPathAndName($data);
        $img = $this->imageFactory->make($data['image']->getRealPath());

        $this->resizeImage($img);

        $img->save($path);

        return $this->getUrlPath($path);
    }

} 