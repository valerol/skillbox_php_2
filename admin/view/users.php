<?php
/**
 * @var $users \Illuminate\Support\Collection
 * @var $pagination \App\Service\Pagination
 */
?>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<a href="/<?= ADMIN_DIR_NAME ?>/users/add" class="btn btn-light">Добавить</a>
<?php include "per_page_selector.php"; ?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Имя</th>
            <th scope="col">Почта</th>
            <th scope="col">Статус</th>
            <th scope="col">Подписка</th>
            <th scope="col">Роль</th>
            <th scope="col">Редактировать</th>
            <th scope="col">Удалить</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) : ?>
        <tr class="<?= !$user->active? 'latent' : '' ?>">
            <td>
                <?php if ($user->avatar) : ?>
                <img src="/<?= USERS_IMAGES_DIR_NAME . $user->avatar; ?>">
                <?php endif; ?>
            </td>
            <td><?= $user->name; ?></td>
            <td><?= $user->email; ?></td>
            <td><?= $user->active ? 'Активен' : 'Заблокирован'; ?></td>
            <td><?= $user->subscribed ? 'Подписан' : 'Не подписан'; ?></td>
            <td><?= $user->group_id == 10 ? 'Администратор'
                    : ($user->group_id == 5 ? 'Редактор'
                        : ($user->group_id == 2 ? 'Комментатор' : 'Пользователь')); ?></td>
            <td><a href="/<?= ADMIN_DIR_NAME ?>/user/<?= $user->id ?>">Редактировать</a></td>
            <td class="text-danger"><a href="/<?= ADMIN_DIR_NAME ?>/user/delete/<?= $user->id ?>">Удалить</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $pagination->render(); ?>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
