<?php
namespace App;

use App\View\Renderable;
use App\View\View;
use App\Exception\ApplicationException;
use App\Exception\HttpException;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Application
 * @package App
 */
class Application
{
    private Router $router;

    /**
     * Application constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->initialize();
    }

    /**
     * @param string $url
     * @param string $method
     */
    public function run(string $url, string $method)
    {
        try {
            $res = $this->router->dispatch($url, $method);

            if ($res instanceof Renderable) {
                $res->render();
            } else {
                print $res;
            }
        } catch (ApplicationException $e) {
            $this->renderException($e);
        }
    }

    /**
     * @param ApplicationException $e
     */
    private function renderException(ApplicationException $e)
    {
        if ($e instanceof Renderable) {
            $e->render();
        } elseif ($e instanceof HttpException) {
            http_response_code(500);
            $view = new View('view.error', ['title' => $e->getMessage()]);
            $view->render();
        }
    }

    private function initialize()
    {
        $capsule = new Capsule;

        $config = Config::getInstance();

        $capsule->addConnection($config->get('db'));

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
    }
}
