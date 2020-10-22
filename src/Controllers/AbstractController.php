<?php

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class AbstractController
{
    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('templates');
        $this->twig = new Environment($loader);
    }

    protected function render(string $name, array $context = [])
    {
        echo $this->twig->render($name, $context);
    }
}
