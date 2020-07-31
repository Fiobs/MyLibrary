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

        // Если класа не существует выдаем ошибку
        if (!class_exists($controller)) {
            throw new \ErrorException('Controller does not exist');
        }

//        var_dump($controller);
        // Создаем экземпляр класса контроллера
        $objController = new $controller;


        // Если у контролера отсутствует метод, кинуть исключение
        if (!method_exists($objController, $action)) {
            throw new \ErrorException('Action does not exist');
        }

        // Вызываем метод у контроллера
        $objController->$action();
    }
}