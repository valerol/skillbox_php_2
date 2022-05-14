<?php
use App\Model\User;
use App\Model\Page;

$user = User::getBySession();

$pages = Page::where('active', 1)->get();

$current_uri = $_SERVER['REQUEST_URI'];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item<?= $current_uri == '/' ? ' active' : '' ?>">
                <a class="nav-link" href="/">Главная</a>
            </li>
            <li class="nav-item<?= $current_uri == '/posts/' ? ' active' : '' ?>">
                <a class="nav-link" href="/posts">Статьи</a>
            </li>
            <?php foreach ($pages as $page_data) : // TODO current active?>
            <li class="nav-item<?= $current_uri == '/pages/' . $page_data->path . '/' ? ' active' : '' ?>">
                <a class="nav-link" href="/<?= $page_data->path ?>"><?= $page_data->title ?></a>
            </li>
            <?php endforeach; ?>

            <?php if (!$user->group_id) : ?>
                <li class="nav-item<?= $current_uri == '/login/' ? ' active' : '' ?>">
                    <a class="nav-link" href="/login">Войти</a>
                </li>
                <li class="nav-item<?= $current_uri == '/register/' ? ' active' : '' ?>">
                    <a class="nav-link" href="/register">Зарегистрироваться</a>
                </li>
            <?php else : ?>
                <li class="nav-item<?= $current_uri == '/account/' ? ' active' : '' ?>">
                    <a class="nav-link" href="/account">Личный кабинет</a>
                </li>
                <?php if (isset($user) && $user->group_id >= 5) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Админка</a>
                    </li>
                <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link" href="/logout">Выйти</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
