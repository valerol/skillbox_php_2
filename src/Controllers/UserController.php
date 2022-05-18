<?php
namespace App\Controllers;

use App\Exception\ApplicationException;
use App\View\View;
use App\Model\User;
use App\Model\Group;
use App\Model\Subscription;
use App\Model\Comment;
use App\Service\Pagination;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController extends AbstractAccessController
{
    /**
     * @return View
     */
    public function loginPage() : View
    {
        return new View('view.login', ['title' => 'Войти']);
    }

    /**
     * @return View
     */
    public function loginAction() : View
    {
        $errors = [];

        if (
            !empty($_POST['email']) &&
            !empty($_POST['password'])
        )
        {
            $user = User::getByEmail($_POST['email']);

            if (isset($user->password)) {

                if (password_verify($_POST['password'], $user->password)) {
                    $_SESSION['login'] = $user->name;
                    $this->redirect('/');
                } else {
                    $errors[] = "Пароль не верен";
                }
            } else {
                $errors[] = "Данный email не зарегистрирован";
            }
        } else {
            $errors[] = "Не все поля заполнены";
        }

        return new View('view.login', ['title' => 'Войти', 'errors' => $errors]);
    }

    /**
     * Actions on logout
     */
    public function logoutAction()
    {
        session_unset();
        $this->redirect('/');
    }

    /**
     * @return View
     */
    public function registerPage() : View
    {
        return new View('view.register', ['title' => 'Зарегистрироваться']);
    }

    /**
     * @return View
     */
    public function registerAction() : View
    {
        $errors_form = [];

        $field_error = [
            'name' => 'Введите имя',
            'email' => 'Введите email',
            'password' => 'Введите пароль',
            'password2' => 'Подтвердите пароль',
            'agreement' => 'Согласитесь с правилами'
        ];

        foreach ($field_error as $field => $error) {

            if (empty($_POST[$field])) {
                $errors_form[$field] = $error;
            }
        }

        if (empty($errors_form)) {

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors_form['email'] = "Некорректный формат email";
            } elseif ($_POST['password'] != $_POST['password2']) {
                $errors_form['password'] = 'Пароли не совпадают';
            } elseif (User::getByName($_POST['name'])) {
                $errors_form['name'] = 'Пользователь с таким именем уже существует';
            } elseif (User::getByEmail($_POST['email'])) {
                $errors_form['email'] = 'Пользователь с таким email уже существует';
            } else {
                $data = [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
                ];

                $user_id = User::addNewId($data);

                if (isset($user_id)) {
                    $_SESSION['login'] = User::getById($user_id)->name;
                    $this->redirect('/account/');
                }
            }
        }

        return new View('view.register', [
            'title' => 'Зарегистрироваться',
            'errors_form' => $errors_form
        ]);
    }

    /**
     * @return View
     */
    public function accountUpdatePage() : View
    {
        $group_description = !empty($this->user) ?
            User::getGroup($this->user->group_id)->description : '';

        return new View('view.account', [
            'title' => 'Мой профиль',
            'user' => $this->user,
            'group' => $group_description
        ]);
    }

    /**
     * @return View
     * @throws ApplicationException
     */
    public function accountUpdateAction() : View
    {
        $errors_form = [];

        $group_description = $this->user->group_id ?
            User::getGroup($this->user->group_id)->description : '';

        $fields = [
            'name',
            'email',
            'about',
            'password'
        ];

        $data = [];

        foreach ($fields as $field) {

            if (isset($_POST[$field]) && $this->user->$field != $_POST[$field]) {

                if (($field == 'name' || $field == 'email')
                    && empty($_POST[$field])) {
                    $errors_form[$field] = 'Это поле не может быть пустым';
                }

                if ($field == 'password') {

                    if ($_POST['password'] == '') {
                        continue;
                    } elseif ($_POST['password'] != $_POST['password2']) {
                        $errors_form['password'] = 'Пароль и проверочный пароль не совпадают';
                    } else {
                        $data[$field] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    }
                } elseif ($field == 'name' && User::getByName($_POST[$field])) {
                    $errors_form['name'] = 'Пользователь с таким именем уже существует';
                } elseif ($field == 'email' && User::getByEmail($_POST[$field])) {
                    $errors_form['email'] = 'Пользователь с таким email уже существует';
                } else {
                    $data[$field] = strip_tags($_POST[$field]);
                    // Set subscription user is subscribed and new email not in list
                    if ($field == 'email' && $this->user->subscribed == 1
                        && !Subscription::getByEmail($_POST[$field])) {
                        Subscription::addNew($_POST[$field]);
                    }
                }
            }
        }

        if (empty($errors_form)) {

            if ((isset($_POST['subscribed']) && $this->user->subscribed != 1)
                || ! isset($_POST['subscribed']) && $this->user->subscribed == 1) {
                $data['subscribed'] = $this->user->subscribed == 1 ? 0 : 1;

                if ($this->user->subscribed == 1) {
                    Subscription::removeByEmail($this->user->email);
                } elseif (!Subscription::getByEmail($this->user->email)) {
                    Subscription::addNew($this->user->email);
                }
            }

            if (!empty($_FILES['avatar']['name'])) {
                try {
                    $filename = file_upload(APP_DIR . USERS_IMAGES_DIR_NAME, 'avatar');
                    $data['avatar'] = $filename;
                } catch (ApplicationException $e) {
                    $errors_form['avatar'] = $e->getMessage();
                }
            }
        }

        if (!empty($data) && empty($errors_form)) {
            $this->user->update($data);
        }

        return new View('view.account', [
            'title' => 'Мой профиль',
            'user' => $this->user,
            'group' => $group_description,
            'errors_form' => $errors_form
        ]);
    }

    /**
     * @param string $paramsuserList
     * @return View
     */
    public function userList(string $params = '') : View
    {
        $this->checkAccess(10);

        $pagination = new Pagination('User', $params);

        return new View('admin.view.users', [
            'title' => 'Пользователи',
            'users' => $pagination->getData(),
            'pagination' => $pagination
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function userUpdatePage(int $id) : View
    {
        $this->checkAccess(10);

        $account = User::getById($id);
        $account_group = User::getGroup($account->group_id);

        return new View('admin.view.user', [
            'title' => 'Пользователь',
            'account' => $account,
            'account_group' => $account_group,
            'groups' => Group::getAll()
        ]);
    }

    /**
     * @param int $id
     * @return View
     * @throws ApplicationException
     */
    public function userUpdateAction(int $id) : View
    {
        $account = User::getById($id);
        $errors_form = [];

        $fields = [
            'name',
            'email',
            'about',
            'group_id',
            'password'
        ];

        $data = [];

        foreach ($fields as $field) {

            if (isset($_POST[$field]) && $account->$field != $_POST[$field]) {

                if ($field == 'password') {

                    if ($_POST['password'] == '') {
                        continue;
                    } elseif ($_POST['password'] != $_POST['password2']) {
                        $errors_form['password'] = "Пароль и проверочный пароль не совпадают";
                    } else {
                        $data[$field] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    }
                } elseif ($field == 'name' && User::getByName($_POST[$field])) {
                    $errors_form['name'] = 'Пользователь с таким именем уже существует';
                } elseif ($field == 'email' && User::getByEmail($_POST[$field])) {
                    $errors_form['email'] = 'Пользователь с таким email уже существует';
                } elseif ($field == 'group_id') {
                    $data[$field] = $_POST[$field];
                } else {
                    $data[$field] = strip_tags($_POST[$field]);

                    // Set subscription user is subscribed and new email not in list
                    if ($field == 'email' && $account->subscribed == 1
                        && !Subscription::getByEmail($_POST[$field])) {
                        Subscription::addNew($_POST[$field]);
                    }
                }
            }
        }

        if ((isset($_POST['subscribed']) && $account->subscribed != 1)
            || ! isset($_POST['subscribed']) && $account->subscribed == 1) {
            $data['subscribed'] = $account->subscribed == 1 ? 0 : 1;
            $account->subscribed == 1 ? Subscription::removeByEmail($account->email)
                : Subscription::addNew($account->email);
        }

        if (!empty($_FILES['avatar']['name'])) {
            try {
                $filename = file_upload(APP_DIR . USERS_IMAGES_DIR_NAME, 'avatar');
                $data['avatar'] = $filename;
            } catch (ApplicationException $e) {
                $errors_form['avatar'] = $e->getMessage();
            }
        }

        if (!empty($data)) {
            $account->update($data);
        }

        return new View('admin.view.user', [
            'title' => 'Пользователь',
            'account' => $account,
            'groups' => Group::getAll(),
            'errors_form' => $errors_form
        ]);
    }

    /**
     * @return View
     */
    public function userAddPage() : View
    {
        $this->checkAccess(10);

        return new View('admin.view.user_add',
            ['title' => 'Добавить пользователя', 'groups' => Group::getAll()]);
    }

    /**
     * @return View
     */
    public function userAddAction() : View
    {
        $errors = [];

        $fields = [
            'name',
            'email',
            'password',
            'group_id'
        ];

        foreach($fields as $field) {

            if (empty($_POST[$field])) {
                $errors[] = "Поле $field должно быть заполнено";
            } elseif ($field == 'password') {
                $data[$field] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            } elseif ($field == 'group_id') {
                $data[$field] = $_POST[$field];
            } else {
                $data[$field] = strip_tags($_POST[$field]);
            }
        }

        if (!empty($data) && empty($errors)) {
            $user_id = User::addNewId($data);

            if ($user_id) {
                $this->redirect('/admin/users/');
            }
        }

        return new View('admin.view.user_add', [
            'title' => 'Добавить пользователя',
            'groups' => Group::getAll(),
            'errors' => $errors
        ]);
    }

    /**
     * @param int $id
     */
    public function userDelete(int $id)
    {
        $this->checkAccess(10);

        $user = User::getById($id);
        // Remove related image files
        if (!empty($user->avatar)) {
            unlink(APP_DIR . USERS_IMAGES_DIR_NAME . $user->avatar);
        }

        // Remove related comments
        $comments = Comment::getByUserId($id);

        if ($comments) {

            foreach ($comments as $comment) {
                Comment::removeById($comment->id);
            }
        }

        User::removeById($id);

        $this->redirect('/admin/users/');
    }
}
