<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<form action="" method="post" enctype="multipart/form-data">
    <?php foreach($settings as $setting) : // TODO вывод других вариантов инпутов реализовать по мере добавления опций ?>
    <div class="mb-3">
        <label for="exampleInputName" class="form-label"><?= $setting->label ?></label>
        <input type="<?= $setting->type ?>" class="form-control" name="<?= $setting->name ?>" value="<?= $setting->value ?>">
    </div>
    <?php endforeach; ?>
    <button type="submit" name="submit" class="btn btn-primary">Сохранить</button>
</form>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
