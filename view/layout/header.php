<?php include VIEW_DIR . "layout/base/header.php"; ?>
<?php include VIEW_DIR . "menu.php"; ?>
<div class="container">
    <?php if (!empty($errors)) include VIEW_DIR . 'errors.php'; ?>
    <?php if (!empty($success)) : ?>
        <p class="list-group-item-success p-2"><?= $success ?></p>
    <?php endif ?>
    <h1 class="title"><?= $title ?></h1>
