<?php
/**
 * Я в курсе, что в Laravel есть пагинатор, но возникли проблемы с вызовом шаблона в методе links(),
 * сходу не разобралась, может библиотеки какой-то не хватает, поэтому написала свой
 */
namespace App\Controllers;

use App\View\View;
use App\View\Renderable;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Pagination
 * @package App\Controllers
 */
class Pagination implements Renderable
{
    private $model;
    public $pages_count = 1;
    public $page = 1;
    public $per_page = 20;
    public $path = '';

    /**
     * Pagination constructor.
     * @param string $model
     * @param string $params
     */
    public function __construct(string $model, string $params = '')
    {
        $this->model = '\App\Model\\' . $model;

        if (!empty($params)) {
            $this->prepareParams($params);
        }
    }

    /**
     * @param string $params
     */
    private function prepareParams(string $params)
    {
        parse_str(str_replace('?', '', $params), $params);

        if (isset($params['page'])) {
            $this->page = $params['page'];
        }

        if (isset($params['per_page'])) {
            $this->per_page = $params['per_page'];
        }
    }

    /**
     * @param array $condition
     */
    private function setPagesCount(array $condition = [])
    {
        $this->pages_count = ceil($this->model::countByCond($condition) / $this->per_page);
    }

    /**
     * @param string $path
     */
    public function setPath(string $path = '')
    {
        $this->path = $path;
    }

    /**
     * @param array $condition
     * @return Collection
     */
    public function getData(array $condition = []) : Collection
    {
        $this->setPagesCount($condition);
        return $this->model::getPaginatedByCond($this->page, $this->per_page, $condition);
    }

    /**
     * Rendering pagination
     */
    public function render()
    {
        $view = new View('view.pagination',
            ['pagination' => $this]);
        $view->render();
    }
}
