<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/27/2014
 * Time: 12:22 PM
 */

namespace Scrib\Service\Form\Users;

use Scrib\Service\Validation\AbstractLaravelValidator;

class ResetPasswordLaravelValidator extends AbstractLaravelValidator {

    protected $rules = array(
        'old_password' => 'required|min:8',
        'password'     => 'required|min:8|confirmed'
    );

    protected $messages = array(
        'old_password'       => 'Please supply your current password.',
        'password.min'       => 'Password must be at least 8 characters',
        'password.confirmed' => 'Passwords does not match confirmation'
    );
} 