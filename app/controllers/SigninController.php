<?php

use Phalcon\Mvc\Controller;

class SigninController extends Controller
{
	public function indexAction()
	{
		$sessions = $this->getDI()->getShared("session");

		if ($sessions->has("userId")) {
			return $this->response->redirect("admin");
		}

		if (!$this->getError()) {
			$password = $this->request->getPost("password");
			$email = $this->request->getPost("email");

			$user = Users::findFirst([
				"conditions" => "email = ?0",
				"bind" => [
					0 => $email
				]
			]);


			if ($user) {
				if ($this->security->checkHash($password, $user->password)) {
					$sessions->set("userId", $user->id);

					return $this->response->redirect('admin');
				} else {
					$this->flash->error("wrong user / password");
				}
			} else {
				$this->flash->error("wrong user / password");
			}
		}
	}

	private function getError() {
		if ($this->request->isPost()) {
			$form = new SigninForm();

			if (false === $form->isValid($this->request->getPost())) {
				$messages = $form->getMessages();
				foreach ($messages as $message) {
					$this->flash->error($message);
				}

				return true;
			}

			return false;
		}

		return true;
	}
}