<?php
declare(strict_types=1);

class IndexController extends ControllerBase
{

    public function indexAction()
    {
	    if (!empty($this->session->get('userId'))) {
		    $user = Users::findFirst([
			    "conditions" => "id = ?0",
			    "bind" == [
				    0 => $this->session->get('userId'),
			    ]
		    ]);

		    $this->view->user_name = $user->name;
	    } else {
		    $this->view->user_name = '';
	    }
    }

}

