<?php


namespace Controllers;


use System\View;


class HomeController
{
    // Home page
    public function indexAction()
    {
     // Отображение главной страницы
        View::render('home');
    }
}