<?php

use Scrib\Repo\Author\AuthorInterface;
use Scrib\Repo\ContentImage\ProfileImage;

class AuthorController extends BaseController {

	protected $author;
	protected $profileImage;

	public function __construct(AuthorInterface $author, ProfileImage $profileImage)
	{
		$this->author = $author;
		$this->profileImage = $profileImage;
	}

	public function setProfileImage()
	{
		$author = $this->author->byUserId(Auth::user()->id);

		$img_name = $this->createImageName($author->fullname);
		$dataURL = $this->getUsableDataURL(Input::get('image'));

		$path = $this->profileImage->store($dataURL, $img_name);
		
		if( $path )
		{
			$author->profilepic = $path;
			$author->save();

			return Response::make('Success');
		}
				
		return Response::make('Failed to save image', 500);
	}

	protected function createImageName($name)
	{
		$img_name = str_replace(array(' ', '.', '\''), '', $name);
		$img_name .= strtotime("now");
		return $img_name;
	}

	protected function getUsableDataURL($dataURL)
	{
		$image_data = str_replace('data:image/png;base64,', '', $dataURL);
		$image_data = str_replace(' ', '+', $image_data);

		return $image_data;
	}
}