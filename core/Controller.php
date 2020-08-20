<?php

namespace app\core;

class Controller
{
    protected $layout = 'main';

    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    public function render(string $view, array $params = [])
    {
        Application::$app->router->setLayout($this->layout);
        return Application::$app->router->renderView($view, $params);
    }
}