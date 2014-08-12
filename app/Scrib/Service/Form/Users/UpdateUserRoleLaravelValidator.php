<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/26/2014
 * Time: 4:29 PM
 */

namespace Scrib\Service\Form\Users;

use Scrib\Service\Validation\AbstractLaravelValidator;

class UpdateUserRoleLaravelValidator extends AbstractLaravelValidator {

    protected $rules = array(
        'role_id' => 'required|integer|in:1,2,3'
    );

    protected $messages = array(
        'role_id' => 'A valid role id needs to be given.'
    );
} 