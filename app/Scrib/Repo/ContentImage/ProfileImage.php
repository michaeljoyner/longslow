<?php namespace Scrib\Repo\ContentImage;

use Intervention\Image\ImageManager;

class ProfileImage {
	protected $imageFactory;
	protected $BASE_FOLDER = '/profile/';

	public function __construct(ImageManager $imageFactory)
	{
		$this->imageFactory = $imageFactory;
	}

	public function store($imageDataURL, $name)
	{
		try
		{
			$this->imageFactory->make(base64_decode($imageDataURL))->save(public_path().$this->BASE_FOLDER.$name.'.jpg', 90);
			return $this->BASE_FOLDER.$name.'.jpg';	
		}
		catch(Exception $e)
		{
			return false;
		}
		
	}
}