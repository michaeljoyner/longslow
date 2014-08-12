<?php namespace Scrib\Repo\Status;

interface StatusInterface {

	/**
	 * get all statuses
	 * @return array Collection of Statuses
	 */
	public function all();

	/**
	 * get status by Id
	 * @param  int $id status Id
	 * @return object     Status object
	 */
	public function byId($id);

	/**
	 * get status by slug
	 * @param  string $status Status slug
	 * @return object         Status object
	 */
	public function byStatus($status);
}