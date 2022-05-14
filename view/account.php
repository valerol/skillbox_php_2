<?php include VIEW_DIR . "layout/header.php"; ?>
<?php if (!empty($user->avatar)) : ?>
<img src="/<?= USERS_IMAGES_DIR_NAME . $user->avatar ?>">
<?php endif ?>
<p><?= $group ?></p>
<form action="/account/" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Имя</label>
        <?php if (isset($errors_form['name'])) : ?>
            <p class="list-group-item-danger p-2"><?= $errors_form['name'] ?></p>
        <?php endif ?>
        <input type="text" class="form-control" name="name" id="exampleInputName" value="<?= $user->name ? $user->name : ''?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <?php if (isset($errors_form['email'])) : ?>
            <p class="list-group-item-danger p-2"><?= $errors_form['email'] ?></p>
        <?php endif ?>
        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?=
        $user->email ? $user->email : ''?>">
    </div>
    <?php if (isset($errors_form['avatar'])) : ?>
        <p class="list-group-item-danger p-2"><?= $errors_form['avatar'] ?></p>
    <?php endif ?>
    <div class="input-group mb-3">
        <input type="file" class="form-control" id="inputGroupAvatar" name="avatar">
        <label class="input-group-text" for="inputGroupAvatar">Аватар</label>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Дополнительная информация</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="about"><?= $user->about ? $user->about : ''?></textarea>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Изменить пароль</label>
        <?php if (isset($errors_form['password'])) : ?>
            <p class="list-group-item-danger p-2"><?= $errors_form['password'] ?></p>
        <?php endif ?>
        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword2" class="form-label">Повторите пароль</label>
        <input type="password" class="form-control" name="password2" id="exampleInputPassword2">
    </div>
    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="subscribed"<?= $user->subscribed ? ' checked' : ''?>>
        <label class="form-check-label" for="flexCheckChecked">Подписаться на статьи</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Сохранить</button>
</form>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
