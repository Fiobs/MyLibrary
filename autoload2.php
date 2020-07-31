<?php


function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = $namespace . '\\';
    }

    $fileName .= $className . '.php';
    require $fileName;
}

spl_autoload_register('autoload');