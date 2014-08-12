<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/26/2014
 * Time: 4:36 PM
 */

namespace Scrib\Service\Form\Users;

use Scrib\Repo\User\UserModelInterface;
use Scrib\Service\Form\ValidatingForm;
use Scrib\Service\Validation\ValidableInterface;

class UpdateUserRoleForm extends ValidatingForm {

    protected $validator;
    protected $user;

    public function __construct(ValidableInterface $validator, UserModelInterface $user){
        $this->validator = $validator;
        $this->user = $user;
    }

    public function save($input)
    {
        if( ! $this->valid($input))
        {
            return false;
        }

        $this->user->updateUserRole($input);

        return true;
    }
} 