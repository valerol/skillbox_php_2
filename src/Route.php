<?php
namespace App;

use Closure;

/**
 * Class Route
 * @package App
 */
class Route
{
    private string $method;
    private string $path;
    private Closure $callback;

    /**
     * Route constructor.
     * @param string $method
     * @param string $path
     * @param array $callback
     */
    public function __construct(string $method, string $path, array $callback)
    {
        $this->method   = $method;
        $this->path     = $path;
        $this->callback = $this->prepareCallback($callback);
    }

    /**
     * @param array $callback
     * @return Closure
     */
    private function prepareCallback(array $callback): Closure
    {
        return function (...$params) use ($callback) {
            list($class, $method) = $callback;
            return (new $class)->{$method}(...$params);
        };
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $uri
     * @param string $method
     * @return bool
     */
    public function match(string $uri, string $method): bool
    {
        return preg_match('/^' . str_replace(['*', '/'], ['[^/]*', '\/'], $this->getPath()) . '$/', $uri)
            && $method == $this->method;
    }

    /**
     * @param string $uri
     * @return false|mixed
     */
    public function run(string $uri)
    {
        $params = array_diff(explode('/', $uri), explode('/', $this->getPath()));
        return call_user_func_array($this->callback, $params);
    }
}
