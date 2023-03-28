<?php

namespace App\Core;

class Router {

    private array $routeArr;
    private ?Response $response = null;
    private array $request = [];

    public function __construct()
    {
        $this->parse();
    }

    private function parse(): void
    {
        $this->routeArr = explode('/', $_SERVER['REQUEST_URI']);
    }

    private function processRequest(
        string $url,
        string $method,
        string $callback
    ): void
    {
        if ($this->response !== null) {
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            return;
        }

        if (!count(array_diff(explode('/', $url), $this->routeArr))) {
            $callbackArr = explode('@', $callback);
            $class = "App\\Controllers\\" . $callbackArr[0];
            $classMethod = $callbackArr[1];
            $this->response = (new $class)->$classMethod();
        }
    }

    public function get(
        string $url,
        string $callback
    ): void
    {
        $this->processRequest($url, 'GET', $callback);
    }

    public function post(
        string $url,
        string $callback
    ): void
    {
        $this->processRequest($url, 'POST', $callback);
    }

    public function response(): void
    {
        if ($this->response === null) {
            http_response_code(404);
            return;
        }

        $this->response->run();
    }

}