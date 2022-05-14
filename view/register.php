<?php include VIEW_DIR . "layout/header.php"; ?>
<form action="/register/" method="post">
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Имя</label>
        <?php if (isset($errors_form['name'])) : ?>
            <p class="list-group-item-danger p-2"><?= $errors_form['name'] ?></p>
        <?php endif; ?>
        <input type="text" class="form-control" name="name" id="exampleInputName">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <?php if (isset($errors_form['email'])) : ?>
            <p class="list-group-item-danger p-2"><?= $errors_form['email'] ?></p>
        <?php endif; ?>
        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Пароль</label>
        <?php if (isset($errors_form['password'])) : ?>
            <p class="list-group-item-danger p-2"><?= $errors_form['password'] ?></p>
        <?php endif; ?>
        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword2" class="form-label">Повторите пароль</label>
        <?php if (isset($errors_form['password2'])) : ?>
            <p class="list-group-item-danger p-2"><?= $errors_form['password2'] ?></p>
        <?php endif; ?>
        <input type="password" class="form-control" name="password2" id="exampleInputPassword2">
    </div>
    <?php if (isset($errors_form['agreement'])) : ?>
        <p class="list-group-item-danger p-2"><?= $errors_form['agreement'] ?></p>
    <?php endif; ?>
    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="agreement" checked>
        <label class="form-check-label" for="flexCheckChecked">
            Согласен с <a href="/agreement">правилами сайта</a>
        </label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>
<?php
include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php";
?>
