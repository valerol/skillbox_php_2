<?php
namespace App\Exception;

use App\View\Renderable;
use App\View\View;

/**
 * Class AccessDeniedException
 * @package App\Exception
 */
class AccessDeniedException extends HttpException implements Renderable
{
    /**
     * Renders Access Denied Exception page
     */
    public function render()
    {
        header('HTTP/1.0 403 Forbidden', TRUE, 403);
        $view = new View('view.error', ['title' => 'Ошибка 403. Недостаточно прав для просмотра страницы']);
        $view->render();
    }
}
