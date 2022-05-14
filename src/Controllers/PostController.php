<?php
namespace App\Controllers;

use App\Exception\ApplicationException;
use App\View\View;
use App\Model\User;
use App\Model\Post;
use App\Model\Subscription;
use App\Model\Comment;
use App\Model\Setting;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PostController
 * @package App\Controllers
 */
class PostController extends AbstractAccessController
{
    /**
     * @param $post_id
     * @param User|null $user
     * @return Collection
     */
    private function prepareComments($post_id, User $user = null) : Collection
    {
        if (!$user->group_id) {
            $comments = Comment::getActiveByPostIdWithUser($post_id);
        } elseif ($user->group_id < 5) {
            $comments = Comment::getActiveAndPersonalByPostIdWithUser($post_id, $user->id);
        } else {
            $comments = Comment::getByPostIdWithUser($post_id);
        }
        return $comments;
    }

    /**
     * @param string $params
     * @return Pagination
     */
    private function prepareFrontendPagination(string $params = '') : Pagination
    {
        parse_str(str_replace('?', '', $params), $params);

        if (!isset($params['per_page'])) {
            $params['per_page'] = Setting::getByName('posts_per_page')->value;
        }

        $pagination = new Pagination('Post', http_build_query($params));

        $pagination->setPath('posts');

        return $pagination;
    }

    /**
     * @param string $params
     * @return View
     */
    public function postList(string $params = '') : View
    {
        $pagination = $this->prepareFrontendPagination($params);

        return new View('view.posts',
            ['title' => 'Записи', 'user' => $this->user, 'posts' => $pagination->getData(['active' => 1]),
                'pagination' => $pagination]);
    }

    /**
     * @param string $params
     * @return View
     */
    public function postSubscribeAction(string $params = '') : View
    {
        $errors = [];

        $success = '';

        $pagination = $this->prepareFrontendPagination($params);

        if (isset($_POST['email'])) {

            User::subscribe($this->user->id);
            $this->user->fresh();

            try {
                Subscription::addNew($_POST['email']);
                $success = "Вы успешно подписались";
            } catch(ApplicationException $e) {
                $errors[] = $e->getMessage();
            }
        }

        return new View('view.posts',
            ['title' => 'Записи', 'user' => $this->user, 'posts' => $pagination->getData(['active' => 1]),
                'pagination' => $pagination, 'errors' => $errors, 'success' => $success]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function postView(int $id) : View
    {
        $comments = $this->prepareComments($id, $this->user);

        return new View('view.post',
            ['post' => Post::getById($id), 'title' => Post::getById($id)->title, 'comments' => $comments]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function postCommentActionAdd(int $id) : View
    {
        $errors_form = [];

        $data = [];

        if (!empty($_POST['text']))
        {
            $fields = [
                'subject',
                'text',
                'user_id',
                'post_id'
            ];

            foreach ($fields as $field) {

                if ($field == 'user_id' && empty($_POST[$field])) {
                    $errors_form['user_id'] =
                        ERROR_REGISTER;
                    break;
                } elseif (isset($_POST[$field])) {

                    if ($field == 'subject' || $field == 'text') {
                        $data[$field] = strip_tags($_POST[$field]);
                    } else {
                        $data[$field] = $_POST[$field];
                    }
                }
            }

            if (empty($errors_form)) {
                $user_group_id = User::getById($data['user_id'])->group_id;

                if ($user_group_id >= 5) {
                    $data['active'] = 1;
                }

                Comment::addNewId($data);
            }

        } else {
            $errors_form['text'] = 'Не заполнено поле комментария'; // Todo required fields HTML
        }

        $comments = $this->prepareComments($id, $this->user);

        return new View('view.post', ['post' => Post::getById($id), 'title' => Post::getById($id)->title, 'errors_form' => $errors_form,
            'comments' => $comments]);
    }

    /**
     * @param string $params
     * @return View
     */
    public function postListAdmin(string $params = '') : View
    {
        $this->checkAccess(5);

        $pagination = new Pagination('Post', $params);

        return new View('admin.view.posts', ['title' => 'Статьи', 'posts' => $pagination->getData(),
            'pagination' => $pagination]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function postUpdatePage(int $id) : View
    {
        $this->checkAccess(5);

        $post = Post::getById($id);

        return new View('admin.view.post', ['title' => 'Статья', 'post' => $post]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function postUpdateAction(int $id) : View
    {
        $post = Post::getById($id);
        $data = [];
        $errors_form = [];

        $fields = [
            'title',
            'text',
            'description'
        ];

        foreach ($fields as $field) {

            if (isset($_POST[$field]) && $post->$field != $_POST[$field]) {

                if ($field == 'text') {
                    $data[$field] = $_POST[$field];
                } else {
                    $data[$field] = strip_tags($_POST[$field]);
                }
            }
        }

        if ((isset($_POST['active']) && $post->active !== 1) || (!isset($_POST['active']) && $post->active === 1)) {
            $data['active'] = $post->active === 1 ? 0 : 1;
        }

        if (!empty($_FILES['image']['name'])) {
            try {
                $filename = file_upload(APP_DIR . POST_IMAGES_DIR_NAME, 'image');
                $data['image'] = $filename;
            } catch (ApplicationException $e) {
                $errors_form['image'] = $e->getMessage();
            }
        }

        $post->update($data);

        return new View('admin.view.post', ['title' => 'Статья', 'post' => $post, 'errors_form' => $errors_form]);
    }

    /**
     * @return View
     */
    public function postAddPage() : View
    {
        $this->checkAccess(5);

        return new View('admin.view.post_add', ['title' => 'Добавить статью']);
    }

    /**
     * @return View
     */
    public function postAddAction() : View
    {
        $errors = [];

        $data = [];

        if (!empty($_POST['title']))
        {
            $fields = [
                'title',
                'description',
                'text'
            ];

            foreach ($fields as $field) {

                if ($field == 'text') {
                    $data[$field] = $_POST[$field];
                } else {
                    $data[$field] = strip_tags($_POST[$field]);
                }
            }

            if (!empty($_FILES['image']['name'])) {
                try {
                    $filename = file_upload(APP_DIR . POST_IMAGES_DIR_NAME, 'image');
                    $data['image'] = $filename;
                } catch (ApplicationException $e) {
                    $errors[] = 'Ошибка загрузки изображения: ' . $e->getMessage();
                }
            }

            $data['active'] = isset($_POST['active']) ? 1 : 0;

            $post_id = Post::addNewId($data);

            if ($post_id) {

                foreach (Subscription::getAll() as $subscriber) {
                    fake_mail($subscriber, Post::getById($post_id));
                }

                $this->redirect('/admin/post/');
            } else {
                $errors[] = "Произошла какая-то ошибка";
            }

        } else {
            $errors[] = 'Поле заголовка должно быть заполнено';
        }

        return new View('admin.view.post_add', ['title' => 'Добавить статью', 'errors' => $errors]);
    }

    /**
     * @param int $id
     */
    public function postDelete(int $id)
    {
        $this->checkAccess(5);

        $post = Post::getById($id);
        // Remove related image files
        if (!empty($post->image)) {
            unlink(APP_DIR . POST_IMAGES_DIR_NAME . $post->image);
        }

        // Remove related comments
        $comments = Comment::getByPostId($id);

        if ($comments) {

            foreach ($comments as $comment) {
                Comment::removeById($comment->id);
            }
        }

        Post::removeById($id);

        $this->redirect('/admin/posts/');
    }
}
