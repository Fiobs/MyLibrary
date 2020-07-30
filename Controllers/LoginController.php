<?php


namespace Controllers;


use System\View;
use Models\Login;


class LoginController
{
    private $model;

    public function __construct()
    {
        $this->model = new Login();
    }

    public function indexAction()
    {
        if (empty($_COOKIE['login'])){
            View::render('Authorization/login');
        } else {
            header("Location: http://library/home");
        }
    }

    public function loginAction()
    {
        $this->model->login();
    }

    public function checkAction()
    {
        $this->model->check();
    }

    public function logoutAction()
    {
        $this->model->logout();
    }
}