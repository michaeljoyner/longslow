<?php namespace Scrib\Service\Form\Category;

use Scrib\Service\Validation\AbstractLaravelValidator;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/30/2014
 * Time: 11:33 AM
 */

class CreateCategoryLaravelValidator extends AbstractLaravelValidator {
    protected $rules = array(
        'category' => 'required|max:255',
        'cover' => 'mimes:jpeg,jpg,png,gif|max:5000000',
        'description' => 'required'
    );

    protected $messages = array(
        'category.max' => 'Please keep the category title under 255 characters',
        'cover.mimes' => 'That file type is not permitted. Please use jpg, png or gif.'
    );
} 