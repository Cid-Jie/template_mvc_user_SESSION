<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function login(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $control = array_map('trim', $_POST);

            $userManager = new UserManager();
            $user = $userManager->selectOneByEmail($control['email']);

            if ($user && password_verify($control['password'], $user['password']))
            $_SESSION['user_id'] = $user['id'];
            header('Location: /');
            exit();
        }    
        return $this->twig->render('User/login.html.twig');
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit();
    }

    public function register(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //      @todo make some controls and if errors send them to the view
                    $credentials = $_POST;
                    $userManager = new UserManager();
                    if ($userManager->insert($credentials)) {
                        return $this->login();
                    }
        }
        return $this->twig->render('User/register.html.twig');
    }
}
