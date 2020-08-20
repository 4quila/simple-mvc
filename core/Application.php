<?php

namespace app\core;

class Application
{
    public string $test = 'test';
    public static Application $app;
    public Controller $controller;
    public Request $request;
    public Response $response;
    public Router $router;
    public string $ROOT_DIR;

    public function __construct(string $ROOT_DIR)
    {
        self::$app = $this;
        $this->ROOT_DIR = $ROOT_DIR;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}