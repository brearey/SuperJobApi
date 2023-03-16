<?php

spl_autoload_register(
    function (string $class): void {
        $path = $class . '.php';
        if (is_readable($path)) {
            require_once $path;
        }
    }
);