<?php
declare(strict_types=1);

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Email;

use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email as validateEmail;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\PresenceOf;

class SigninForm extends Form
{
	public function initialize()
	{
		// Email
		$email = new Email('email', [
			'placeholder' => 'Email',
		]);

		$email->addValidators([
			new PresenceOf([
				'message' => 'The e-mail is required',
			]),
			new validateEmail([
				'message' => 'The e-mail is not valid',
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
		$this->add(new Submit('Login', [
			'class' => 'btn btn-primary',
		]));
	}

	public function getCsrf()
	{
		return $this->security->getToken();
	}
}