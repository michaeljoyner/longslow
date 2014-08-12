<?php namespace Scrib\Repo\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Hashing\BcryptHasher as Hasher;

class EloquentUserModel implements UserModelInterface {

    protected $user;
    protected $hashFactory;

    public function __construct(Model $user, Hasher $hashFactory)
    {
        $this->user = $user;
        $this->hashFactory = $hashFactory;
    }

    public function create($data)
    {
        $newuser = $this->user->create(array(
            'email'    => $data['email'],
            'password' => $this->hashFactory->make($data['password']),
            'role_id'  => $data['role_id']
        ));

        if ( ! $newuser)
        {
            return false;
        }

        return $newuser->id;
    }

    public function delete($id)
    {
        # code...
    }

    public function update($data)
    {
        # code...
    }

    public function updateEmail($id, $email)
    {
        $user = $this->user->find($id);

        if ( ! $user)
        {
            return false;
        }

        $user->email = $email;
        $user->save();

        return true;
    }

    public function updateUserRole($data)
    {
        $user = $this->user->find($data['id']);

        if ( ! $user)
        {
            return false;
        }

        $user->role_id = $data['role_id'];
        $user->save();

        return true;
    }

    public function resetPassword($data)
    {
        $user = $this->user->find($data['id']);

        if ( ! $user)
        {
            return false;
        }

        if ( ! $this->hashFactory->check($data['old_password'], $user->password))
        {
            return false;
        }

        $user->password = $this->hashFactory->make($data['password']);
        $user->save();

        return true;
    }

    public function byId($id)
    {
        return $this->user->with('author')->where('id', $id)->first();
    }

    public function all()
    {
        return $this->user->with('author')->get();
    }

    public function byRoleId($role_id)
    {
        return $this->user->with('author')
                          ->where('role_id', $role_id)
                          ->get();
    }
}