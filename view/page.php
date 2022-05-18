<?php
/**
 * @var $page \App\Model\Page
 */
?>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "header.php"; ?>
<div class="card">
    <div class="card-body">
        <p class="card-text"><?= $page->text ?></p>
    </div>
</div>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
