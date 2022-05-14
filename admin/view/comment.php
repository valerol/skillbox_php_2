<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Тема</label>
        <input type="text" class="form-control" name="subject" id="exampleInputName" value="<?=
        $comment->subject ? $comment->subject : ''?>">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Содержание</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text"><?=
            $comment->text ? $comment->text : ''?></textarea>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="active"<?=
        $comment->active ? ' checked' : ''?>>
        <label class="form-check-label" for="flexCheckChecked">Опубликовать</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Сохранить</button>
</form>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
