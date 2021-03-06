<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<?php include "per_page_selector.php"; ?>
<div class="clear"></div>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col" class="col-10">Почта</th>
        <th scope="col">Удалить</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($subscriptions as $subscription) : ?>
        <tr>
            <td><?= $subscription->id; ?></td>
            <td><?= $subscription->email; ?></td>
            <td class="text-danger"><a href="/<?= ADMIN_DIR_NAME ?>/subscription/delete/<?=
                $subscription->id ?>">Удалить</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $pagination->render(); ?>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
