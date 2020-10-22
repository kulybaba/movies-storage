<?php

spl_autoload_register(function ($class) {
    $paths = [
        '/src/Models/',
        '/src/Controllers/',
        '/config/components/',
    ];

    foreach ($paths as $path) {
        $path = ROOT . $path . $class . '.php';
        if (is_file($path)) {
            require_once $path;
        }
    }
});
