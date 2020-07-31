<?php


function autoload($className)
{
    $className = ltrim($className, '\\');

    $fileName = $className . '.php';

    if(file_exists($fileName)){
        require_once $fileName;
    } else {
        return false;
    }
}

spl_autoload_register('autoload');