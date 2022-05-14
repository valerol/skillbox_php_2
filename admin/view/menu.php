<?php
use App\Model\User;

$user = User::getBySession();

$current_uri = $_SERVER['REQUEST_URI'];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item <?= $current_uri == '/' ? ' active' : '' ?>">
                <a class="nav-link" href="/">Главная</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/<?= ADMIN_DIR_NAME ?>/posts">Статьи</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/<?= ADMIN_DIR_NAME ?>/comments">Комментарии</a>
            </li>
            <?php if ($user->group_id == 10) : ?>
            <li class="nav-item">
                <a class="nav-link" href="/<?= ADMIN_DIR_NAME ?>/users">Пользователи</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/<?= ADMIN_DIR_NAME ?>/subscriptions">Подписки</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/<?= ADMIN_DIR_NAME ?>/pages">Страницы</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/<?= ADMIN_DIR_NAME ?>/settings">Настройки</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
