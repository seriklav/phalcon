<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

class Users extends Model
{
	public $id;
	public $name;
	public $email;
	public $password;

	protected function validate(\Phalcon\Validation\ValidationInterface $validator): bool
	{
		$validator->add(
			"email",
			new UniquenessValidator()
		);
	}
}