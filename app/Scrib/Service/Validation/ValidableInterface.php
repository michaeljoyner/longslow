<?php namespace Scrib\Service\Validation;

interface ValidableInterface {

	/**
	 * Add data to validate against
	 * @param  array  $input data
	 * @return Scrib\Service\Validation\ValidableInterface 
	 */
	public function with(array $input);

	/**
	 * Test if validation passes
	 * @return bool Is valid
	 */
	public function passes();

	/**
	 * Retrieve validation errors
	 * @return array array of errors
	 */
	public function errors();
}