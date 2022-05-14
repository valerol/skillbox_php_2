<?php

namespace App\Controllers;

use App\View\View;
use App\Model\Comment;

/**
 * Class CommentsController
 * @package App\Controllers
 */
class CommentsController extends AbstractAccessController
{
    /**
     * @param string $params
     * @return View
     */
    public function commentList(string $params = '') : View
    {
        $this->checkAccess(5);

        $pagination = new Pagination('Comment', $params);

        return new View('admin.view.comments', ['title' => 'Комментарии', 'comments' => $pagination->getData(),
            'pagination' => $pagination]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function commentUpdatePage(int $id): View
    {
        $this->checkAccess(5);

        return new View('admin.view.comment', ['title' => 'Комментарий', 'comment' => Comment::getById($id)]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function commentUpdateAction(int $id) : View
    {
        $comment = Comment::getById($id);

        $fields = [
            'subject',
            'text'
        ];

        $data = [];

        foreach ($fields as $field) {

            if (isset($_POST[$field]) && $comment->$field != $_POST[$field]) {
                $data[$field] = strip_tags($_POST[$field]);
            }
        }

        if ((isset($_POST['active']) && $comment->active != 1) || (!isset($_POST['active']) && $comment->active == 1)) {
            $data['active'] = $comment->active == 1 ? 0 : 1;
        }

        if (!empty($data)) {
            $comment->update($data);
        }

        return new View('admin.view.comment', ['title' => 'Комментарий', 'comment' => $comment]);
    }

    /**
     * @param int $id
     */
    public function commentDelete(int $id)
    {
        $this->checkAccess(10);

        Comment::removeById($id);

        $this->redirect('/admin/comments/');
    }
}
