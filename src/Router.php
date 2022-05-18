<?php
namespace App;

use App\Exception\NotFoundException;
use App\Exception\AccessDeniedException;
use App\Model\User;

/**
 * Class Router
 * @package App
 */
class Router
{
    /** @var array|Route[]  */
    private array $routes = [];

    /**
     * @param string $path
     * @param array $callback
     */
    public function get(string $path, array $callback)
    {
        $this->addRoute('get', $path, $callback);
    }

    /**
     * @param string $path
     * @param array $callback
     */
    public function post(string $path, array $callback)
    {
        $this->addRoute('post', $path, $callback);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $callback
     */
    private function addRoute(string $method, string $path, array $callback)
    {
        $this->routes[] = new Route($method, $path, $callback);
    }

    /**
     * @param string $url
     * @param string $method
     * @return false|mixed
     * @throws AccessDeniedException
     * @throws NotFoundException
     */
    public function dispatch(string $url, string $method)
    {
        $uri = trim($url, '/');
        $method = strtolower($method);

        foreach ($this->routes as $route) {

            if ($route->match($uri, $method)) {
                return $route->run($uri);
            }
        }

        throw new NotFoundException();
    }
}
