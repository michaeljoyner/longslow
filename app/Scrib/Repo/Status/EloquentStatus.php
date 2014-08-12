<?php namespace Scrib\Repo\Status;

use Illuminate\Database\Eloquent\Model;

class EloquentStatus implements StatusInterface {

	protected $status;

	public function __construct(Model $status) {
		$this->status = $status;
	}

	/**
	 * get all statuses
	 * @return array Collection of Status obects
	 */
	public function all() {
		return $this->status->all();
	}

	/**
	 * get status by Id
	 * @param  int $id Status id
	 * @return object     Status object
	 */
	public function byId($id) {
		return $this->status->find($id);
	}

	/**
	 * get status by slug
	 * @param  string $status status slug
	 * @return object         Status object
	 */
	public function byStatus($status) {
		return $this->status->where('slug', $status)->get();
	}
}