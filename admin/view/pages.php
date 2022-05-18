<?php
/**
 * @var $pages \Illuminate\Support\Collection
 * @var $pagination \App\Service\Pagination
 */
?>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<?php include "per_page_selector.php"; ?>
<a href="/<?= ADMIN_DIR_NAME ?>/pages/add" class="btn btn-light">Добавить</a>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Название</th>
            <th scope="col">Текст</th>
            <th scope="col">Редактировать</th>
            <th scope="col">Удалить</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pages as $page) : ?>
        <tr class="<?= !$page->active? 'latent' : '' ?>">
            <td><?= $page->title; ?></td>
            <td><?= string_lenght_control(htmlspecialchars($page->text)); ?></td>
            <td><a href="/<?= ADMIN_DIR_NAME?>/page/<?= $page->id ?>">Редактировать</a></td>
            <td class="text-danger"><a href="/<?= ADMIN_DIR_NAME ?>/page/delete/<?= $page->id ?>">Удалить</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $pagination->render(); ?>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
