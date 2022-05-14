<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<?php if (!empty($account->avatar)) : ?>
    <img src="/<?= USERS_IMAGES_DIR_NAME . $account->avatar ?>">
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Имя</label>
        <input type="text" class="form-control" name="name" id="exampleInputName" value="<?=
        $account->name ? $account->name : ''?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?=
        $account->email ? $account->email : ''?>">
    </div>
    <?php if (isset($errors_form['avatar'])) : ?>
        <p class="list-group-item-danger p-2"><?= $errors_form['avatar'] ?></p>
    <?php endif; ?>
    <div class="input-group mb-3">
        <input type="file" class="form-control" id="inputGroupAvatar" name="avatar">
        <label class="input-group-text" for="inputGroupAvatar">Upload</label>
    </div>
    <div class="mb-3">
        <label for="group" class="form-label">Группа</label>
        <select class="form-select" aria-label="group" name="group_id">
            <?php foreach($groups as $group): ?>
                <option value="<?= $group->id ?>"<?= $account->group_id == $group->id ? ' selected' : ''?>>
                    <?= $group->description ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">About me</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="about"><?=
            $account->about ? $account->about : ''?></textarea>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Изменить пароль</label>
        <?php if (isset($errors_form['password'])) : ?>
            <p class="list-group-item-danger p-2"><?= $errors_form['password'] ?></p>
        <?php endif; ?>
        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword2" class="form-label">Повторите пароль</label>
        <input type="password" class="form-control" name="password2" id="exampleInputPassword2">
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="subscribed"<?=
        $account->subscribed ? ' checked' : ''?>>
        <label class="form-check-label" for="flexCheckChecked">Подписать на статьи</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Сохранить</button>
</form>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
