<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
	public function indexAction()
	{
		if (!$this->getError()) {
			$user = new Users();

			$user->assign(
				$this->request->getPost(),
				[
					'name',
					'email',
					'password'
				]
			);

			$user->password = $this->security->hash($this->request->getPost('password'));

			$success = $user->save();

			if ($success) {
				$this->flash->success("Thanks for registering! Now you can login to Admin.");
			} else {
				$messages = $user->getMessages();
				foreach ($messages as $message) {
					$this->flash->error($message);
				}
			}

			return $this->response->redirect('index');
		}
	}

	private function getError() {
		if ($this->request->isPost()) {
			$form = new SignupForm();

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