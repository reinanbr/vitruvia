<?php

namespace Vitruvia\Core\Web;

/**
 * Mirrors Express's `res` object: chainable status()/set(), plus
 * send()/json()/render()/redirect() terminators that write the response.
 */
class Response
{
    protected int $statusCode = 200;
    protected array $headers = [];
    protected bool $sent = false;

    public function status(int $code): static
    {
        $this->statusCode = $code;
        return $this;
    }

    public function set(string $header, string $value): static
    {
        $this->headers[$header] = $value;
        return $this;
    }

    public function send(string $body = ""): void
    {
        $this->flushHeaders();
        echo $body;
        $this->sent = true;
    }

    public function json($data): void
    {
        $this->set("Content-Type", "application/json");
        $this->send(json_encode($data, JSON_PRETTY_PRINT));
    }

    public function render(string $view, array $locals = [], array $layoutParams = []): void
    {
        $this->set("Content-Type", "text/html");
        $this->send(Application::$app->router->renderView($view, $layoutParams, $locals));
    }

    public function redirect(string $url, int $status = 302): void
    {
        $this->status($status)->set("Location", $url);
        $this->send();
    }

    public function end(): void
    {
        if (!$this->sent) {
            $this->send();
        }
    }

    public function isSent(): bool
    {
        return $this->sent;
    }

    protected function flushHeaders(): void
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
    }
}
