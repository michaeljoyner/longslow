<?php namespace Scrib\Repo\ContentImage;

abstract class AbstractImage implements ImageInterface {
	protected $BASE_FOLDER = 'content';


	public function store($data)
	{
		//must be overwritten
	}

	public function get($path)
	{
		//TODO
	}


	protected function getPrefix()
	{
		return time();
	}

	protected function getBasePath() {
		return $this->BASE_FOLDER;
	}

	protected function getFinalPathAndName($data)
	{
		$name = $data['image']->getClientOriginalName();
		$prefix = $this->getPrefix();

		$newpath = $this->getBasePath();
		$newname = $prefix.'_'.$name;

		$finalPath = $newpath.$newname;
//        $finalPath = str_replace('/', '\\', $finalPath);

		return $finalPath;
	}

	protected function getUrlPath($fullPath)
	{
		$pos = strpos($fullPath, '\\'.$this->BASE_FOLDER);
		$path = substr($fullPath, $pos+1);
		$path = str_replace('\\', '/', $path);

		return $path;
	}

	protected function resizeImage($img)
	{
		$currentHeight = $img->height();
		$currentWidth = $img->width();
		$aspectRatio = $currentWidth/$currentHeight;

		if( $currentWidth > $this->MAX_WIDTH )
		{
			return $img->resize($this->MAX_WIDTH, round($this->MAX_WIDTH/$aspectRatio));
		} 
		else if( $currentWidth <= $this->MAX_WIDTH && $currentHeight > $this->MAX_HEIGHT)
		{
			return $img->fit(round($this->MAX_HEIGHT*$aspectRatio), $this->MAX_HEIGHT);
		}
		else 
		{
			return $img;
		}
	}
}