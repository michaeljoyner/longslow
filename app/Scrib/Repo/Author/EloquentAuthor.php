<?php namespace Scrib\Repo\Author;

use Illuminate\Database\Eloquent\Model;
use Scrib\Repo\RepoAbstract;

class EloquentAuthor extends RepoAbstract implements AuthorInterface {

	protected $author;

	public function __construct(Model $author)
	{
		$this->author = $author;
	}

	public function all()
	{
		return $this->author->all();
	}

	public function byId($id)
	{
		return $this->author->find($id);
	}

	public function byUserId($user_id)
	{
		return $this->author->where('user_id', $user_id)->first();
	}

	public function create($data)
	{
		$newauthor = $this->author->create(array(
			'fullname' => $data['fullname'],
			'slug' => $this->slug($data['fullname']),
			'bio' => $data['bio'],
			'user_id' => $data['user_id']
		));

		if( ! $newauthor )
		{
			return false;
		}

		return true;
	}

	public function update($id, $data)
	{
		$author = $this->author->where('user_id', $id)->first();

		if( ! $author )
		{
			return false;
		}

		$author->fullname = $data['fullname'];
		$author->slug = $this->slug($data['fullname']);
		$author->bio = $data['bio'];
		$author->save();

		return true;
	}

	public function destroy($id)
	{
		# code...
	}
}