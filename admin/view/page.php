<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<form action="" method="post">
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Название</label>
        <input type="text" class="form-control" name="title" id="exampleInputName" value="<?= $page->title ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Путь</label>
        <input type="text" class="form-control" name="path" id="exampleInputName" value="<?= $page->path ?>">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Текст</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text"><?= $page->text ?></textarea>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="active"<?= $page->active
            ? ' checked' : ''?>>
        <label class="form-check-label" for="flexCheckChecked">Отображать на сайте</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Сохранить</button>
</form>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
