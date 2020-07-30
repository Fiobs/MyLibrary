<?php


namespace System;


class View
{
    public static function render($path, array $data = [], array $data2 = [])
    {
        // Получаем путь, где лежат все представления
        $fullPath = __DIR__.'/../Views/'.$path.'.php';


        // Если представление небыло найдено, кинуть эксепшн
        if (!file_exists($fullPath)){
            throw new \ErrorException('View cannot be found');
        }


        // Отображение представления
        include ($fullPath);
    }
}