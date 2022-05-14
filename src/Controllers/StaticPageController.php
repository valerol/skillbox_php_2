<?php
namespace App\Controllers;

use App\Exception\NotFoundException;
use App\View\View;
use App\Model\Page;

/**
 * Class StaticPageController
 * @package App\Controllers
 */
class StaticPageController extends AbstractAccessController
{
    /**
     * @param string $params
     * @return View
     */
    public function pageList(string $params = '') : View
    {
        $this->checkAccess(10);

        $pagination = new Pagination('Page', $params);

        return new View('admin.view.pages', ['title' => 'Страницы', 'pages' => $pagination->getData(),
            'pagination' => $pagination]);
    }

    /**
     * @param string $id
     * @return View
     */
    public function pageUpdatePage(string $id) : View
    {
        $this->checkAccess(10);

        $page = Page::getById($id);

        return new View('admin.view.page', ['title' => 'Страница', 'page' => $page]);
    }

    /**
     * @param string $id
     * @return View
     */
    public function pageUpdateAction(string $id) : View
    {
        $page = Page::getById($id);

        $errors = [];

        $fields = [
            'title',
            'path',
            'text'
        ];

        $data = [];

        foreach ($fields as $field) {

            if (isset($_POST[$field]) && $page->$field != $_POST[$field]) {

                if ($field == 'path' && Page::getByPath($_POST[$field])) {
                    $errors[] = 'Страница с таким адресом уже есть';
                    break;
                } elseif ($field == 'text') {
                    $data[$field] = $_POST[$field];
                } else {
                    $data[$field] = strip_tags($_POST[$field]);
                }
            }
        }

        if (empty($errors)) {

            if ((isset($_POST['active']) && $page->active != 1)
                || (!isset($_POST['active']) && $page->active == 1)) {
                $data['active'] = $page->active == 1 ? 0 : 1;
            }

            if (!empty($data)) {
                $page->update($data);
            }
        }

        return new View('admin.view.page', ['title' => 'Страница', 'page' => $page, 'errors' => $errors]);
    }

    /**
     * @return View
     */
    public function pageAddPage() : View
    {
        $this->checkAccess(10);

        return new View('admin.view.page_add', ['title' => 'Добавить страницу']);
    }

    /**
     * @return View
     */
    public function pageAddAction() : View
    {
        $errors = [];
        $errors_form = [];
        $data = [];

        $fields = [
            'title',
            'path',
            'text'
        ];

        foreach ($fields as $field) {

            if ($field == 'path' && Page::getByPath($_POST[$field])) {
                $errors[] = 'Страница с таким адресом уже есть';
                break;
            }

            if (isset($_POST[$field])) {

                if ($field == 'text') {
                    $data[$field] = $_POST[$field];
                } else {
                    $data[$field] = strip_tags($_POST[$field]);
                }
            } else {
                $errors_form[$field] = "Заполните поле $field";
            }
        }

        if (!empty($data) && empty($errors)) {
            $data['active'] = isset($_POST['active']) ? 1 : 0;

            $page_id = Page::addNewId($data);

            if ($page_id) {
                $this->redirect('/admin/pages/');
            } else {
                $errors[] = "Произошла какая-то ошибка";
            }
        }

        return new View('admin.view.page_add',
            ['title' => 'Добавить страницу', 'errors' => $errors, 'errors_form' => $errors_form]);
    }

    /**
     * @param string $path
     * @return View
     * @throws NotFoundException
     */
    public function pageView(string $path) : View
    {
        $page = Page::getByPath($path);

        if (!$page || $page->active != 1) {
            throw new NotFoundException();
        }

        return new View('view.page', ['page' => $page, 'title' => $page->title]);
    }

    /**
     * @param int $id
     */
    public function pageDelete(int $id)
    {
        $this->checkAccess(10);

        Page::removeById($id);

        $this->redirect('/admin/pages/');
    }
}
