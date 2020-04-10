<?php
declare(strict_types=1);

class AdminController extends AdminBase
{
    public function indexAction()
    {
	    $this->view->users = Users::find();
    }

    public function newsAction()
    {

    }

    public function usersAction()
    {
	    $this->view->users = Users::find();
    }
}

