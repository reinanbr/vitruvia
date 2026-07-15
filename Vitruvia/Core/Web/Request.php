<?php

namespace Vitruvia\Core\Web;

use Vitruvia\Core\Web\Config\Http\RequestHttp;

/**
 * Mirrors Express's `req` object: method, path, route params (:id-style),
 * query string and a best-effort parsed body are all available as properties.
 */
class Request extends RequestHttp
{
    public string $method;
    public string $path;
    public array $params = [];
    public array $query = [];
    public array $body = [];
    public array $headers = [];

    public function __construct()
    {
        $this->method = self::getMethod();
        $this->path = self::getPath();
        $this->query = $_GET;
        $this->body = $this->resolveBody();
        $this->headers = function_exists('getallheaders') ? (getallheaders() ?: []) : [];
    }

    protected function resolveBody(): array
    {
        if ($this->method === "GET") {
            return [];
        }

        $raw = file_get_contents("php://input");
        if ($raw !== false && $raw !== "") {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }

        return $_POST;
    }
}
