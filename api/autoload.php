<?php

spl_autoload_register(
    function (string $class): void {

        // Uncomment this for publish on beget
        //$class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        $path = $class . '.php';
        if (is_readable($path)) {
            require_once $path;
        }
    }
);