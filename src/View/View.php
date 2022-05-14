<?php

namespace App\View;

use App\Exception\ApplicationException;

class View implements Renderable
{
    private string $view;

    private array $data;

    public function __construct($view, $data)
    {
        $data['view'] = str_replace('.', '-', $view);
        $this->view = $view;
        $this->data = $data;
    }

    public function render()
    {
        extract($this->data);

        try {
            include $this->getIncludeTemplate($this->view);
        } catch (ApplicationException $e) {
            print $e->getMessage();
        }
    }

    private function getIncludeTemplate($view)
    {
        $template = APP_DIR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';

        if (!file_exists($template)) {
            throw new ApplicationException($template . ' шаблон не найден');
        }

        return $template;
    }
}
