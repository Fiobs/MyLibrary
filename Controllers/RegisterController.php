<?php


namespace Controllers;


use System\View;
use Models\Register;


class RegisterController
{
    private $model;

    public function __construct()
    {
        $this->model = new Register();
    }

    public function indexAction()
    {
        if (empty($_COOKIE['login'])){
            View::render('Authorization/register');
        } else {
            header("Location: http://library/home");
        }
    }

    public function registerAction()
    {
        $this->model->registration();
    }
}