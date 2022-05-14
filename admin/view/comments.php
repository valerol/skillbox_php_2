<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<?php include "per_page_selector.php"; ?>
<div class="clear"></div>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Название</th>
        <th scope="col">Текст</th>
        <th scope="col">Дата публикации</th>
        <th scope="col">Автор</th>
        <th scope="col">Статья</th>
        <th scope="col">Редактировать</th>
        <th scope="col">Удалить</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($comments as $comment) : ?>
        <tr class="<?= !$comment->active ? 'latent' : '' ?>">
            <td><?= $comment->subject; ?></td>
            <td><?= string_lenght_control($comment->text); ?></td>
            <td><?= $comment->created_at; ?></td>
            <td><a href="/<?= ADMIN_DIR_NAME?>/user/<?= $comment->user_id; ?>"><?= $comment->user_id; ?></a></td>
            <td><a href="/<?= ADMIN_DIR_NAME?>/post/<?= $comment->post_id; ?>"><?= $comment->post_id; ?></a></td>
            <td><a href="/<?= ADMIN_DIR_NAME?>/comment/<?= $comment->id ?>">Редактировать</a></td>
            <td class="text-danger"><a href="/<?= ADMIN_DIR_NAME ?>/comment/delete/<?= $comment->id ?>">Удалить</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $pagination->render(); ?>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
