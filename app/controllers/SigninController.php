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
				"conditions" => "email = ?0 AND password = ?1",
				"bind" == [
					0 => $email,
					1 => $this->security->hash($password)
				]
			]);

			if (false === $user) {
				$this->flashSession->error("wrong user / password");

				return $this->view->pick("signin");
			} else {
				$sessions->set("userId", $user->id);
			}

			return $this->response->redirect('admin');
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