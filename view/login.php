<?php include VIEW_DIR . "layout/header.php"; ?>
<form action="/login/" method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
    </div>
    <button type="submit" class="btn btn-primary">Войти</button>
</form>
<a href="/register">Зарегистрироваться</a>
<?php
include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php";
?>
