<?php
/**
 * @var $groups \Illuminate\Support\Collection
 */
?>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "admin_header.php"; ?>
<form action="/<?= ADMIN_DIR_NAME ?>/users/add/" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Имя</label>
        <input type="text" class="form-control" name="name" id="exampleInputName">
    </div>
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Почта</label>
        <input type="text" class="form-control" name="email" id="exampleInputName">
    </div>
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Пароль</label>
        <input type="text" class="form-control" name="password" id="exampleInputName">
    </div>
    <div class="mb-3">
        <label for="group" class="form-label">Группа</label>
        <select class="form-select" aria-label="group" name="group_id">
            <?php foreach($groups as $group): ?>
            <option value="<?= $group->id ?>"><?= $group->description ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Добавить</button>
</form>
<?php include VIEW_DIR . "layout" . DIRECTORY_SEPARATOR . "base/footer.php"; ?>
