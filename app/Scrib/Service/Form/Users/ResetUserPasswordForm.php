<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/27/2014
 * Time: 12:28 PM
 */

namespace Scrib\Service\Form\Users;

use Scrib\Service\Form\ValidatingForm;
use Scrib\Repo\User\UserModelInterface;
use Scrib\Service\Validation\ValidableInterface;

class ResetUserPasswordForm extends ValidatingForm {

    protected $validator;
    protected $user;

    public function __construct(ValidableInterface $validator, UserModelInterface $user)
    {
        $this->validator = $validator;
        $this->user = $user;
    }

    public function save($input)
    {
        if ( ! $this->valid($input))
        {
            return false;
        }

        return $this->user->resetPassword($input);
    }

} 