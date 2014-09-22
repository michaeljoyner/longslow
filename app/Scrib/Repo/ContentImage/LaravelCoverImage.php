<?php namespace Scrib\Repo\ContentImage;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManager;


class LaravelCoverImage extends AbstractImage {
	protected $BASE_FOLDER = '/covers/';
	protected $cover;
	protected $imageFactory;
	protected $MAX_WIDTH = 1280;
	protected $MAX_HEIGHT = 900;

	public function __construct(Model $cover, ImageManager $imageFactory)
	{
		$this->cover = $cover;
		$this->imageFactory = $imageFactory;
	}

	public function store($data)
	{
		$path = $this->getFinalPathAndName($data);

		$img = $this->imageFactory->make($data['image']->getRealPath());

		$this->resizeImage($img);

		$img->save(public_path().$path);

		$coverInstance = $this->cover->create(array(
			'path' => $this->getUrlPath($path)
		));

		return $coverInstance->id;
	}
}