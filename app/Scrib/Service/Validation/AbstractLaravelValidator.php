<?php namespace Scrib\Service\Validation;

use Illuminate\Validation\Factory as Validator;

abstract class AbstractLaravelValidator implements ValidableInterface {

	/**
	 * Validator
	 * @var \Illuminate\Validation\Factory
	 */
	protected $validator;

	/**
	 * Validation data $key => $value array
	 * @var Array
	 */
	protected $data;

	/**
	 * Validation errors
	 * @var Array
	 */
	protected $errors;

	/**
	 * Validation rules
	 * @var Array
	 */
	protected $rules;

	/**
	 * Custom error messages
	 * @var Array
	 */
	protected $messages;

	public function __construct(Validator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Set up data to validate
	 * @param  array  $data data
	 * @return ValiableInterface       
	 */
	public function with(array $data)
	{
		$this->data = $data;

		return $this;
	}


	public function passes()
	{
		$validator = $this->validator->make(
			$this->data,
			$this->rules,
			$this->messages
		);

		if( $validator->fails() )
		{
			$this->errors = $validator->messages();
			return false;
		}

		return true;
	}

	/**
	 * Return any errors
	 * @return array 
	 */
	public function errors()
	{
		return $this->errors;
	}
}