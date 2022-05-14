<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<form action="/<?= ADMIN_DIR_NAME ?>/pages/add/" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Заголовок</label>
        <input type="text" class="form-control" name="title" id="exampleInputName">
    </div>
    <?php if (isset($errors_form['title'])) : ?>
        <p class="list-group-item-danger p-2"><?= $errors_form['title'] ?></p>
    <?php endif; ?>
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Путь</label>
        <input type="text" class="form-control" name="path" id="exampleInputName">
    </div>
    <?php if (isset($errors_form['path'])) : ?>
        <p class="list-group-item-danger p-2"><?= $errors_form['path'] ?></p>
    <?php endif; ?>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Текст</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text"></textarea>
    </div>
    <?php if (isset($errors_form['text'])) : ?>
        <p class="list-group-item-danger p-2"><?= $errors_form['text'] ?></p>
    <?php endif; ?>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="active" checked>
        <label class="form-check-label" for="flexCheckChecked">Отображать на сайте</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Сохранить</button>
</form>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
