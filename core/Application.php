<?php

namespace app\core;

class Application
{
    public string $test = 'test';
    public static Application $app;
    public Controller $controller;
    public Request $request;
    public Database $database;
    public Response $response;
    public Session $session;
    public Router $router;
    public string $ROOT_DIR;

    public function __construct(string $ROOT_DIR, array $config)
    {
        self::$app = $this;
        $this->ROOT_DIR = $ROOT_DIR;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->database = new Database($config['db']);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}