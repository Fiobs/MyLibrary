<?php


namespace System;


class App
{
    // Запуск приложения

    public static function run($a)
    {
        //  Присваивание URL запроса
        $path = $_SERVER['REQUEST_URI'];
        $s = $_SERVER['REQUEST_METHOD'];

        // Дробим URL
        $pathParts = explode('/', $path);

        $controller = 'home';
        $action = 'index';

        // Получаем имя контроллера
        if (array_key_exists(1, $pathParts) && $pathParts[1]) {
            $controller = $pathParts[1];
        }

        // Получаем имя экшена
        if (array_key_exists(2, $pathParts)) {
            $action = $pathParts[2];
        }

        // Формируем пространство имен для контроллера
        $controller = 'Controllers\\' . ucfirst($controller) . 'Controller';

        // Формируем наименование действия
        $action = $action . 'Action';

        // Если класа не существует выдаем 404
        if (!class_exists($controller)) {
            $controller = 'Controllers\\HomeController';
            $action = "cheatersAction";
        }

        // Создаем экземпляр класса контроллера
        $objController = new $controller;

        // Если у контролера отсутствует метод, кинуть 404
        if (!method_exists($objController, $action)) {
            $action = "cheatersAction";
            $controller = 'Controllers\\HomeController';
            $objController = new $controller;
        }

        // Вызываем метод у контроллера
        $objController->$action();
    }
}