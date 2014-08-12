<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/26/2014
 * Time: 4:42 PM
 */

namespace Scrib\Service\Form;


abstract class ValidatingForm {
    protected $validator;
    /**
     * Return any validation errors
     * @return array
     */
    public function errors()
    {
        return $this->validator->errors();
    }

    /**
     * helper to Test if validation passes
     * @param  array  $input
     * @return bool
     */
    protected function valid(array $input)
    {
        return $this->validator->with($input)->passes();
    }
} 