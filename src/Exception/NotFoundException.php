<?php
namespace App\Exception;

use App\View\Renderable;
use App\View\View;

/**
 * Class NotFoundException
 * @package App\Exception
 */
class NotFoundException extends HttpException implements Renderable
{
    /**
     * Renders Not Found Exception page
     */
    public function render()
    {
        header('HTTP/1.0 404 Not Found', TRUE, 404);
        $view = new View('view.error', ['title' => 'Ошибка 404. Страница не найдена']);
        $view->render();
    }
}
