<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

class AdminBase extends Controller
{
	public function initialize()
	{
		if (empty($this->session->get('userId')))
		{
			$this->response->redirect('index');
		}
	}
}
