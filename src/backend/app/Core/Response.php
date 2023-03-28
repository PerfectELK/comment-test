<?php

namespace App\Core;

class Response {

    private array $headers = [];
    private string $content;

    private function getDefaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json'
        ];
    }

    public function json(array $content): Response
    {
        $this->content = json_encode($content);
        return $this;
    }

    public function setHeader($key, $value): void
    {
        $this->headers[$key] = $value;
    }
    private function headers(): void
    {
        $headers = array_merge($this->getDefaultHeaders(), $this->headers);
        foreach ($headers as $key => $header) {
            header("{$key}: {$header}");
        }
    }
    public function run(): void
    {
        $this->headers();
        echo $this->content;
    }

}