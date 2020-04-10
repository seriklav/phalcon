<?php
declare(strict_types=1);

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class SignupForm extends Form
{
	public function initialize()
	{
		// Name
		$name = new Text('name', [
			'placeholder' => 'Name',
		]);

		$name->addValidators([
			new PresenceOf([
				'message' => 'The name is required',
			])
		]);

		$name->addValidator(
			new StringLength(
				[
					'min'            => 3,
					'messageMinimum' => 'The name is too short',
				]
			)
		);

		$this->add($name);

		// Email
		$email = new Text('email', [
			'placeholder' => 'Email',
		]);

		$email->addValidators([
			new PresenceOf([
				'message' => 'The e-mail is required',
			]),
			new Email([
				'message' => 'The e-mail is not valid',
			]),
			new \Phalcon\Validation\Validator\Uniqueness([
				'message' => 'This e-mail exist',
				'model' => new Users()
			])
		]);


		$this->add($email);

		// Password
		$password = new Password('password', [
			'placeholder' => 'Password',
		]);
		$password->addValidator(new PresenceOf([
			'message' => 'The password is required',
		]));

		$password->clear();

		$this->add($password);

		// CSRF
		$csrf = new Hidden('csrf');
		$csrf->addValidator(new Identical([
			'value'   => $this->security->getRequestToken(),
			'message' => 'CSRF validation failed',
		]));
		$csrf->clear();

		$this->add($csrf);
		$this->add(new Submit('Register', [
			'class' => 'btn btn-primary',
		]));
	}

	public function getCsrf()
	{
		return $this->security->getToken();
	}
}