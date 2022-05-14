<?php

define('APP_DIR', $_SERVER['DOCUMENT_ROOT'] . '/');
define('VIEW_DIR', $_SERVER['DOCUMENT_ROOT'] . '/view/');
define('ADMIN_DIR_NAME', 'admin');
define('POST_IMAGES_DIR_NAME', 'images/posts/');
define('USERS_IMAGES_DIR_NAME', 'images/users/');

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

session_start();

