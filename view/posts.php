<?php include VIEW_DIR . "layout/header.php"; ?>
<?php if (!$user->subscribed) : ?>
<form action="" method="post">
    <div class="input-group mb-3">
        <input type="email" class="form-control<?= !$user->email ? '' : ' hidden' ?>" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" value="<?= isset($user->email) ? $user->email : ''?>">
        <button type="submit" name="submit" class="btn btn-primary">Подписаться</button>
    </div>
</form>
<?php endif; ?>

<?php foreach($posts as $post): ?>
<div class="row">
    <div class="col-3">
        <?php if ($post->image) : ?>
        <img src="<?= '/' . POST_IMAGES_DIR_NAME . $post->image ?>" alt="<?= $post->title ?>">
        <?php endif; ?>
    </div>
    <div class="col">
        <h2><a href="/post/<?= $post->id ?>"><?= $post->title ?></a></h2>
        <p><?= $post->description ?></p>
        <p><small class="text-muted"><?= $post->created_at ?></small></p>
    </div>
</div>
<?php endforeach ?>
<?php $pagination->render(); ?>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
