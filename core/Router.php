<?php

namespace app\core;

class Router
{
    public array $routes = [];
    protected Request $request;
    protected Response $response;
    protected string $layout = 'main';

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->uri();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false)
        {
            $this->response->statusCode(404);
            return $this->renderView('_404');
        }
        elseif (is_string($callback))
        {
            return $this->renderView($callback);
        }
        elseif (is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }
        
        return call_user_func($callback, $this->request);
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function renderView(string $view, array $params = [])
    {
        $layout = $this->renderLayout();
        $content = $this->renderOnlyView($view, $params);
        $view = str_replace('{{content}}', $content, $layout);
        return $view;
    }

    public function renderOnlyView(string $view, array $params)
    {
        foreach ($params as $key => $value)
        {
            $$key = $value;
        }
        ob_start();
        include Application::$app->ROOT_DIR . "/views/$view.html.php";
        return ob_get_clean();
    }

    public function renderLayout()
    {
        ob_start();
        include Application::$app->ROOT_DIR . "/views/layouts/$this->layout.html.php";
        return ob_get_clean();
    }
}