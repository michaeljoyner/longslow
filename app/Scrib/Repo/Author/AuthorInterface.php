<?php namespace Scrib\Repo\Author;

interface AuthorInterface {

	public function all();

	public function byId($id);

	public function byUserId($user_id);

	public function create($data);

	public function update($id, $data);

	public function destroy($id);
}