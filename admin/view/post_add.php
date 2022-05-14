<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<form action="/admin/posts/add/" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Заголовок</label>
        <input type="text" class="form-control" name="title" id="exampleInputName">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Описание</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Текст</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text"></textarea>
    </div>
    <div class="input-group mb-3">
        <input type="file" class="form-control" id="inputGroupAvatar" name="image">
        <label class="input-group-text" for="inputGroupAvatar">Иллюстрация</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="active" checked>
        <label class="form-check-label" for="flexCheckChecked">Опубликовать</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Сохранить</button>
</form>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
