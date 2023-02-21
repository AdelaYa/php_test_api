<?php

namespace Controllers;

use Models\AuthModel;

use Core\BaseController;
use Core\BaseView;


class AuthController extends BaseController
{
    public function loginAction()
    {
        $model = new AuthModel();
        if ($this->validateLoginData($model)) {
            header('Location: /category/category');
            exit();
        }
        return $this->output('Auth/login');
    }

    public function validateLoginData($model)
    {
        /** @var AuthModel $model */


        if (isset($_POST['authorization_login']) and isset($_POST['authorization_password'])) {
            $login = htmlspecialchars(trim($_POST['authorization_login']));
            $password = $_POST['authorization_password'];
            $data = array('login' => $login, 'password' => $password);
            $result = $model->checkInDb($data);
            if (is_array($result)) {


                $_SESSION['userId'] = $result["id"];
                $_SESSION['userName'] = $result["login"];
                $_SESSION['userPassword'] = $result["password_hash"];

//                    setcookie('userId', $result["id"], time() + 3600);
//                    header('Location: /category');
//                    exit;
                return true;
            }
        }
        return false;
    }


    public function registerAction(): BaseView
    {
        $model = new AuthModel();
        if ($this->validateRegisterData($model)) {
            header('Location: /index/index');
            exit();
        }
        return $this->output('Auth/register');


    }


    public function validateRegisterData($model)
    {
        /** @var AuthModel $model */
        if (isset($_POST['register_login']) and isset($_POST['register_password'])) {
            $login = htmlspecialchars(trim($_POST['register_login']));
            $password = $_POST['register_password'];
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $data = array('login' => $login, 'password' => $hash);

            $model->addUserToDb($data);
            return true;
        }
        return false;
    }

    public
    function logoutAction(): BaseView
    {
        if ($_SESSION['userId']) {
            unset($_SESSION['userId']);
            unset($_SESSION['userName']);
            unset($_SESSION['userPassword']);

            header('Location: /index/index');
            exit();
        }
        return $this->output('Auth/logout');
    }

}