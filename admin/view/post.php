<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Заголовок</label>
        <input type="text" class="form-control" name="title" id="exampleInputName" value="<?=
        $post->title ? $post->title : ''?>">
    </div>
    <?php if ($post->image) : ?>
    <img class="card-img-top" src="<?= '/' . POST_IMAGES_DIR_NAME . $post->image ?>">
    <?php endif; ?>
    <div class="input-group mb-3">
        <input type="file" class="form-control" id="inputGroupAvatar" name="image">
        <label class="input-group-text" for="inputGroupAvatar">Изображение</label>
    </div>
    <?php if (isset($errors_form['image'])) : ?>
        <p class="list-group-item-danger p-2"><?= $errors_form['image'] ?></p>
    <?php endif; ?>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Описание</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"><?=
            $post->description ? $post->description : ''?></textarea>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Текст</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text"><?=
            $post->text ? $post->text : ''?></textarea>
    </div>
    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="active"<?=
        $post->active ? ' checked' : ''?>>
        <label class="form-check-label" for="flexCheckChecked">Опубликовать</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Сохранить</button>
</form>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
