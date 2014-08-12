<?php namespace Scrib\Repo\User;

interface UserModelInterface {

	/**
	 * create a new user model
	 * @param  array $input array of user attributes
	 * @return bool        true on success
	 */
	public function create($data);

	/**
	 * delete user
	 * @param  integer $id id of user to delete
	 * @return bool     true on success
	 */
	public function delete($id);

	/**
	 * update user model
	 * @param  array $input attributes to update (should include id of model)
	 * @return bool        true on success
	 */
	public function update($data);

	/**
	 * update email for given user id
	 * @param  int $id    user id
	 * @param  string $email validated email address
	 * @return bool        
	 */
	public function updateEmail($id, $email);

    public function updateUserRole($data);

    public function resetPassword($data);

	/**
	 * get user by id
	 * @param  integer $id 
	 * @return object     user object
	 */
	public function byId($id);

	/**
	 * get all users
	 * @return array 
	 */
	public function all();

	/**
	 * get all users with a specified role id
	 * @param  integer $role_id role_id
	 * @return array     
	 */
	public function byRoleId($role_id);
}