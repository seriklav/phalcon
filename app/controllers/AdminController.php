<?php
declare(strict_types=1);

class AdminController extends AdminBase
{
    public function indexAction()
    {
	    $user = Users::findFirst([
		    "conditions" => "id = ?0",
		    "bind" == [
			    0 => $this->session->get('userId'),
		    ]
	    ]);

	    $this->view->user = $user;
    }

    public function newsAction()
    {

    }

    public function usersAction()
    {
	    $this->view->users = Users::find();
    }

    public function logoutAction()
    {
	    $this->session->remove('userId');
	    $this->response->redirect('index');
    }
}

