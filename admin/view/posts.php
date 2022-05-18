<?php
/**
 * @var $posts \Illuminate\Support\Collection
 * @var $pagination \App\Service\Pagination
 */
?>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<a href="/admin/posts/add" class="btn btn-light">Добавить статью</a>
<?php include "per_page_selector.php"; ?>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Иллюстрация</th>
        <th scope="col">Название</th>
        <th scope="col">Описание</th>
        <th scope="col">Дата публикации</th>
        <th scope="col">Статус</th>
        <th scope="col">Редактировать</th>
        <th scope="col">Удалить</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $post) : ?>
        <tr class="<?= !$post->active? 'latent' : '' ?>">
            <td>
            <?php if ($post->image) : ?>
                <img src="<?= '/' . POST_IMAGES_DIR_NAME . $post->image ?>" alt="<?= $post->title ?>">
            <?php endif; ?>
            </td>
            <td><?= $post->title; ?></td>
            <td><?= $post->description; ?></td>
            <td><?= $post->created_at; ?></td>
            <td><?= $post->active; ?></td>
            <td><a href="/<?= ADMIN_DIR_NAME ?>/post/<?= $post->id ?>">Редактировать</a></td>
            <td class="text-danger"><a href="/<?= ADMIN_DIR_NAME ?>/post/delete/<?= $post->id ?>">Удалить</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $pagination->render(); ?>
<!--
<tr class="table-primary">...</tr>
<tr class="table-secondary">...</tr>
<tr class="table-success">...</tr>
<tr class="table-danger">...</tr>
<tr class="table-warning">...</tr>
<tr class="table-info">...</tr>
<tr class="table-light">...</tr>
<tr class="table-dark">...</tr>
-->

<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
