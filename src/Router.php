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
     * @param int $group_id
     */
    public function get(string $path, array $callback, $group_id = 0)
    {
        $this->addRoute('get', $path, $callback, $group_id);
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
     * @param int $group_id
     */
    private function addRoute(string $method, string $path, array $callback, int $group_id = 0)
    {
        $this->routes[] = new Route($method, $path, $callback, $group_id);
    }

    /**
     * @param Route $route
     * @return bool|void
     */
    private function checkAccess(Route $route) {

        if ($route->group_id == 0) {
            return true;
        } elseif (isset($_SESSION['login'])) {
            $user = User::where('name', $_SESSION['login'])->first();

            if ($user) {
                return $route->group_id <= $user->group_id;
            }
        } else return;
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

                if (!$this->checkAccess($route)) {
                    throw new AccessDeniedException();
                }
                return $route->run($uri);
            }
        }

        throw new NotFoundException();
    }
}
