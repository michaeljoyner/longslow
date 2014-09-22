<?php namespace Scrib\Repo\ContentImage;

use Intervention\Image\ImageManager;

class LaravelContentImage extends AbstractImage {
	protected $BASE_FOLDER = '/content/';
	protected $MAX_WIDTH = 600;
	protected $MAX_HEIGHT = 400;
	protected $imageFactory;

	public function __construct(ImageManager $imageFactory)
	{
		$this->imageFactory = $imageFactory;
	}

	public function store($data)
	{
		$path = $this->getFinalPathAndName($data);
		$img = $this->imageFactory->make($data['image']->getRealPath());

		$this->resizeImage($img);

		$img->save(public_path().$path);

		return $this->getUrlPath($path);
	}
	
}