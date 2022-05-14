<?php
define('ERROR_REGISTER', '<a href="/register/">Зарегистрируйтесь</a>, чтобы иметь возможность оставить комментарий.');
include VIEW_DIR . "layout/header.php";
?>
<div class="row">
    <?php if ($post->image) : ?>
    <div class="col-3">
        <img src="<?= '/' . POST_IMAGES_DIR_NAME . $post->image ?>" alt="<?= $post->title ?>">
    </div>
    <?php endif ?>
    <div class="col">
        <p><small class="text-muted"><?= $post->created_at ?></small></p>
        <p><?= $post->description ?></p>
    </div>
</div>
<div class="row">
    <div class="col">
        <p class="card-text"><?= $post->text ?></p>
    </div>
</div>
<?php if (count($comments) > 0) : ?>
    <h2>Комментарии</h2>
    <?php foreach ($comments as $comment): ?>
    <div class="row<?= $comment->active == 1 ? '' : ' latent'?>">
        <div class="col-2">
            <?php if ($comment->avatar) : ?>
            <img src="<?= '/' . USERS_IMAGES_DIR_NAME . $comment->avatar ?>" alt="<?= $comment->name ?>">
            <?php endif ?>
        </div>
        <div class="col">
            <p><small class="text-muted"><?= $comment->name ?></small></p>
            <?php if (isset($comment->subject)) : ?><h3><?= $comment->subject ?></h3><?php endif ?>
            <p><?= $comment->text ?></p>
            <p><small class="text-muted"><?= $comment->created_at ?></small></p>
            <?php if ($comment->active != 1) : ?>
            <p><i><small class="text-muted">(Комментарий на модерации)</small></i></p>
            <?php endif ?>
        </div>
    </div>
    <?php endforeach ?>
<?php endif ?>
<h3 id="add_comment">Добавить комментарий</h3>
<form action="#add_comment" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Заголовок</label>
        <input type="text" class="form-control" name="subject" id="exampleInputName">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Комментарий</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text"></textarea>
        <?php if (isset($errors_form['text'])) : ?>
            <p class="list-group-item-danger p-2"><?= $errors_form['text'] ?></p>
        <?php endif ?>
    </div>
    <input type="hidden" name="user_id" value="<?= isset($user) ? $user->id : '' ?>">
    <input type="hidden" name="post_id" value="<?= isset($post) ? $post->id : '' ?>">
    <?php if (isset($errors_form['user_id'])) : ?>
        <p class="list-group-item-danger p-2"><?= $errors_form['user_id'] ?></p>
    <?php endif ?>
    <button type="submit" name="submit" class="btn btn-primary">Сохранить</button>
</form>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
