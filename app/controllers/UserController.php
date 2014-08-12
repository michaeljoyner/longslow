<?php

use Scrib\Service\Form\Users\CreateUserForm;
use Scrib\Service\Form\Users\UpdateUserForm;
use Scrib\Service\Form\Users\UpdateUserRoleForm;
use Scrib\Service\Form\Users\ResetUserPasswordForm;
use Scrib\Repo\User\UserModelInterface;

class UserController extends \BaseController {

    protected $createForm;
    protected $updateForm;
    protected $updateRoleForm;
    protected $resetPasswordForm;
    protected $user;

    public function __construct(CreateUserForm $createForm, UserModelInterface $user, UpdateUserForm $updateForm, UpdateUserRoleForm $updateRoleForm, ResetUserPasswordForm $resetUserPasswordForm)
    {
        $this->createForm = $createForm;
        $this->updateForm = $updateForm;
        $this->updateRoleForm = $updateRoleForm;
        $this->resetPasswordForm = $resetUserPasswordForm;
        $this->user = $user;
    }

    /**
     * Display a listing of users/team
     *
     * @return Response
     */
    public function index()
    {
        $honchos = $this->user->byRoleId(1);
        $editors = $this->user->byRoleId(2);
        $writers = $this->user->byRoleId(3);

        return View::make('admin.users.userindex', compact('honchos', 'editors', 'writers'));
    }


    /**
     * Show the form for creating a new user
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.users.createuser');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        if ($this->createForm->save($input))
        {
            return Redirect::route('admin.article.index')->with('flash_message', 'User created successfully');
        }

        return Redirect::route('user.create')->withErrors($this->createForm->errors())->withInput();
    }


    /**
     * Display the specified profile
     *
     * @param  int $id
     * @return Response
     */
    public function showProfileForm($id)
    {
        $profile = $this->user->byId($id);
        return View::make('admin.profile.profile')->with('profile', $profile);
    }

    /**
     * Display reset password form for logged in user
     * @return \Illuminate\View\View
     */
    public function showPasswordReset()
    {
        $user = $this->user->byId(Auth::user()->id);
        return View::make('admin.users.resetpassword')->with('user', $user);
    }


    /**
     * Show the form for editing the specified user
     *(for honchos to edit other users profile or role)
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $profile = $this->user->byId($id);
        return View::make('admin.users.edituser')->with('profile', $profile);
    }


    /**
     * Update the specified profile
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $input = array_merge(Input::all(), array('id' => Auth::user()->id));


        if ($this->updateForm->save($input))
        {
            return Redirect::route('admin.article.index')->with('flash_message', 'Profile updated');
        }

        return Redirect::route('user.show', $id)->withErrors($this->updateForm->errors())->withInput();
    }

    /**
     * Update users role
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUserRole($id)
    {
        $input = array(
            'id'      => $id,
            'role_id' => Input::get('role_id')
        );

        if ($this->updateRoleForm->save($input))
        {
            return Redirect::route('user.index')->with('flash_message', 'User updated');
        }

        return Redirect::route('user.edit', $id)->withErrors($this->updateRoleForm->errors())->withInput();
    }

    /**
     * Update users password
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetUserPassword($id)
    {
        $input = array(
            'id'                    => Auth::user()->id,
            'old_password'          => Input::get('old_password'),
            'password'              => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation')
        );

        if ($this->resetPasswordForm->save($input))
        {
            return Redirect::route('admin.article.index')->with('flash_message', 'Password reset successfully');
        }

        return Redirect::route('user.showpasswordreset')->with('flash_message', 'Failed to reset password')->withErrors($this->resetPasswordForm->errors());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->user->byId($id);

        if ( ! $user)
        {
            return Redirect::route('user.edit', $id)->with('flash_message', 'Unable to delete user');
        }

        $user->delete();

        return Redirect::route('user.index')->with('flash_message', 'User deleted!');
    }
}
