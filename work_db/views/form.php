<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Регистрация на конференцию</title>
    <style>.error { color: red; }</style>
</head>
<body>
<?php if (!empty($errors)): ?>
    <p class="error"><b>Проверьте правильность заполнения формы!</b></p>
<?php endif; ?>

<form action="" method="POST">
    <div>
        <label>Имя:</label>
        <input type="text" name="name" value="<?= htmlspecialchars(
            $formData["name"] ?? "",
        ) ?>">
        <span class="error"><?= $errors["name"] ?? "" ?></span>
    </div>
    <div>
        <label>Фамилия:</label>
        <input type="text" name="lastname" value="<?= htmlspecialchars(
            $formData["lastname"] ?? "",
        ) ?>">
        <span class="error"><?= $errors["lastname"] ?? "" ?></span>
    </div>
    <div>
        <label>Почта:</label>
        <input type="text" name="email" value="<?= htmlspecialchars(
            $formData["email"] ?? "",
        ) ?>">
        <span class="error"><?= $errors["email"] ?? "" ?></span>
    </div>
    <div>
        <label>Телефон:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars(
            $formData["phone"] ?? "",
        ) ?>">
        <span class="error"><?= $errors["phone"] ?? "" ?></span>
    </div>
    <div>
        <label>Тема конференции:</label>
        <select name="subject_id">
            <option value="">-- Выберите тему --</option>
            <?php foreach ($subjects as $id => $name): ?>
                <option value="<?= $id ?>" <?= ($formData["subject_id"] ??
    "") ==
$id
    ? "selected"
    : "" ?>>
                    <?= htmlspecialchars($name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="error"><?= $errors["subject_id"] ?? "" ?></span>
    </div>
    <div>
        <label>Способ оплаты:</label>
        <select name="payment_id">
            <option value="">-- Выберите способ --</option>
            <?php foreach ($payments as $id => $name): ?>
                <option value="<?= $id ?>" <?= ($formData["payment_id"] ??
    "") ==
$id
    ? "selected"
    : "" ?>>
                    <?= htmlspecialchars($name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="error"><?= $errors["payment_id"] ?? "" ?></span>
    </div>
    <div>
        <label>
            <input type="checkbox" name="agreed" value="yes" <?= ($formData[
                "agreed"
            ] ??
                "") ===
            "yes"
                ? "checked"
                : "" ?>>
            Хотите ли вы получать рассылку?
        </label>
    </div>
    <div>
        <button type="submit">Отправить</button>
    </div>
</form>
</body>
</html>
