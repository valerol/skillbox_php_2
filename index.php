<?php

use App\Application;
use App\Controllers\AdminController;
use App\Controllers\StaticPageController;
use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Controllers\CommentsController;
use App\Controllers\SubscriptionsController;
use App\Controllers\SettingsController;
use App\Router;

use App\Model\User;

error_reporting(E_ALL);
ini_set('display_errors',true);

require_once __DIR__ . '/bootstrap.php';

$router = new Router();

/* ADMIN PostController */
$router->get(ADMIN_DIR_NAME, [PostController::class, 'postListAdmin'], 5);
$router->get(ADMIN_DIR_NAME . '/posts', [PostController::class, 'postListAdmin'], 5);
$router->get(ADMIN_DIR_NAME . '/posts/add', [PostController::class, 'postAddPage'], 5);
$router->get(ADMIN_DIR_NAME . '/posts/*', [PostController::class, 'postListAdmin'], 5);
$router->get(ADMIN_DIR_NAME . '/post/*', [PostController::class, 'postUpdatePage'],5);
$router->get(ADMIN_DIR_NAME . '/post/delete/*', [PostController::class, 'postDelete'], 5);
$router->post(ADMIN_DIR_NAME . '/posts/add', [PostController::class, 'postAddAction']);
$router->post(ADMIN_DIR_NAME . '/post/*', [PostController::class, 'postUpdateAction']);

/* ADMIN UserController */
$router->get(ADMIN_DIR_NAME . '/users', [UserController::class, 'userList'], 10);
$router->get(ADMIN_DIR_NAME . '/users/add', [UserController::class, 'userAddPage'], 10);
$router->get(ADMIN_DIR_NAME . '/users/*', [UserController::class, 'userList'], 10);
$router->get(ADMIN_DIR_NAME . '/user/*', [UserController::class, 'userUpdatePage'], 10);
$router->get(ADMIN_DIR_NAME . '/user/delete/*', [UserController::class, 'userDelete'], 10);
$router->post(ADMIN_DIR_NAME . '/users/add', [UserController::class, 'userAddAction']);
$router->post(ADMIN_DIR_NAME . '/user/*', [UserController::class, 'userUpdateAction']);

/* ADMIN StaticPageController */
$router->get(ADMIN_DIR_NAME . '/pages', [StaticPageController::class, 'pageList'], 10);
$router->get(ADMIN_DIR_NAME . '/pages/add', [StaticPageController::class, 'pageAddPage'], 10);
$router->get(ADMIN_DIR_NAME . '/pages/*', [StaticPageController::class, 'pageList'], 10);
$router->get(ADMIN_DIR_NAME . '/page/*', [StaticPageController::class, 'pageUpdatePage'], 10);
$router->get(ADMIN_DIR_NAME . '/page/delete/*', [StaticPageController::class, 'pageDelete'], 10);
$router->post(ADMIN_DIR_NAME . '/pages/add', [StaticPageController::class, 'pageAddAction']);
$router->post(ADMIN_DIR_NAME . '/page/*', [StaticPageController::class, 'pageUpdateAction']);

/* ADMIN CommentController */
$router->get(ADMIN_DIR_NAME . '/comments', [CommentsController::class, 'commentList'], 5);
$router->get(ADMIN_DIR_NAME . '/comments/*', [CommentsController::class, 'commentList'], 5);
$router->get(ADMIN_DIR_NAME . '/comment/*', [CommentsController::class, 'commentUpdatePage'], 5);
$router->get(ADMIN_DIR_NAME . '/comment/delete/*', [CommentsController::class, 'commentDelete'], 10);
$router->post(ADMIN_DIR_NAME . '/comment/*', [CommentsController::class, 'commentUpdateAction']);


$router->get(ADMIN_DIR_NAME . '/subscriptions', [SubscriptionsController::class, 'subscriptionList'], 10);
$router->get(ADMIN_DIR_NAME . '/subscriptions/*', [SubscriptionsController::class, 'subscriptionList'], 10);
$router->get(ADMIN_DIR_NAME . '/subscription/delete/*', [SubscriptionsController::class, 'subscriptionDelete'], 10);

$router->get(ADMIN_DIR_NAME . '/settings', [SettingsController::class, 'settingList'], 10);
$router->post(ADMIN_DIR_NAME . '/settings', [SettingsController::class, 'settingUpdateAction']);

/* ADMIN HOME (PostController) */
$router->get(ADMIN_DIR_NAME . '/*', [PostController::class, 'postListAdmin'], 5);

/* FRONTEND PostController */
$router->get('', [PostController::class, 'postList']);
$router->get('posts', [PostController::class, 'postList']);
$router->get('posts/*', [PostController::class, 'postList']);
$router->get('post', [PostController::class, 'postView']);
$router->get('post/*', [PostController::class, 'postView']);
$router->post('', [PostController::class, 'postSubscribeAction']);
$router->post('posts', [PostController::class, 'postSubscribeAction']);
$router->post('posts/*', [PostController::class, 'postSubscribeAction']);
$router->post('post', [PostController::class, 'postCommentActionAdd']);
$router->post('post/*', [PostController::class, 'postCommentActionAdd']);

/* FRONTEND UserController */
$router->get('logout', [UserController::class, 'logoutAction']);
$router->get('login', [UserController::class, 'loginPage']);
$router->get('register', [UserController::class, 'registerPage']);
$router->get('account', [UserController::class, 'accountUpdatePage'], 1);
$router->post('login', [UserController::class, 'loginAction']);
$router->post('register', [UserController::class, 'registerAction']);
$router->post('account', [UserController::class, 'accountUpdateAction']);

/* FRONTEND StaticPageController */
$router->get('unsubscribe/*', [SubscriptionsController::class, 'unsubscribeAction']);
$router->get('*', [StaticPageController::class, 'pageView']);

$application = new Application($router);

$application->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
