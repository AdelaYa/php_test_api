<?php

namespace Controllers;

use Core\BaseController;
use Core\BaseView;

class IndexController extends BaseController
{
    public function indexAction(): BaseView {
        $name = 'user';
        if ($_SESSION) {
            $name = $_SESSION['userName'];
        }

        // $this->page404();

        return $this->output('Index/main', [
            'name' => $name
        ]);
    }
}