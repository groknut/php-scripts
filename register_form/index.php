<?php

$topics = [
    1 => "Бизнес",
    2 => "Технологии",
    3 => "Реклама и Маркетинг",
];

$payments = [
    1 => "WebMoney",
    2 => "Яндекс.Деньги",
    3 => "PayPal",
    4 => "Кредитная карта",
];

// --- Вспомогательные функции ---

function validateForm(array $data): array
{
    $errors = [];
    $digits = preg_replace("/\D/", "", $data["phone"]);

    $emailPattern = "/^[A-Za-z0-9._\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/";

    if (empty($data["name"])) {
        $errors["name"] = "Поле с именем обязательно к заполнению!";
    }
    if (empty($data["lastname"])) {
        $errors["lastname"] = "Поле с фамилией обязательно к заполнению!";
    }
    if (empty($data["email"])) {
        $errors["email"] =
            "Поле с адресом электронной почты обязательно к заполнению!";
    } elseif (!preg_match($emailPattern, $data["email"])) {
        $errors["email"] = "Ошибка в написании адреса электронной почты!";
    }
    if (empty($data["phone"])) {
        $errors["phone"] = "Поле с телефоном обязательно к заполнению!";
    } elseif (strlen($digits) !== 11 || !in_array($digits[0], ["7", "8"])) {
        $errors["phone"] = "Неверный формат номера телефона!";
    }

    if (empty($data["topic"])) {
        $errors["topic"] = "Поле с темой обязательно к заполнению!";
    }
    if (empty($data["payment"])) {
        $errors["payment"] = "Поле с методом оплаты обязательно к заполнению!";
    }

    if (empty($data["agreed"])) {
        $data["agreed"] = "no";
    }

    return $errors;
}

function saveFormData(array $data): string
{
    $date = new DateTime();
    $filename = sprintf("./data/file_%s.txt", $date->format("Y-m-d_H-i-s"));

    $content = print_r(
        [
            "name" => $data["name"] ?? "",
            "lastname" => $data["lastname"] ?? "",
            "email" => $data["email"] ?? "",
            "phone" => $data["phone"] ?? "",
            "topic" => $data["topic"] ?? "",
            "payment" => $data["payment"] ?? "",
            "agreed" => $data["agreed"] ?? "no",
        ],
        true,
    );
    file_put_contents($filename, $content);
    return $filename;
}

$source = $_GET["source"] ?? null;

if ($source === "waiting") {
    sleep(3);
    header("Location: global.php?source=true");
    exit();
}

$showSuccess = $source === "true";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $formData = $_POST;
    $errors = validateForm($formData);

    if (empty($errors)) {
        saveFormData($formData);
        header("Location: global.php?source=waiting");
        exit();
    }
} else {
    $formData = [];
    $errors = [];
}

if (!$showSuccess): ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Регистрация на конференцию</title>
    <style>
        .error { color: red; }
        .success { color: green; }
    </style>
    <link rel="stylesheet" href="./assets/main.css" />
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
        <label>Выберите тематику конференции:</label>
        <select name="topic">
            <option value="">-- Выберите тему --</option>
            <?php foreach ($topics as $key => $value): ?>
                <option value="<?= $key ?>"
                    <?= ($formData["topic"] ?? "") == $key ? "selected" : "" ?>>
                    <?= htmlspecialchars($value) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="error"><?= $errors["topic"] ?? "" ?></span>
    </div>

    <div>
        <label>Выберите метод оплаты:</label>
        <select name="payment">
            <option value="">-- Выберите способ оплаты --</option>
            <?php foreach ($payments as $key => $value): ?>
                <option value="<?= $key ?>"
                    <?= ($formData["payment"] ?? "") == $key
                        ? "selected"
                        : "" ?>>
                    <?= htmlspecialchars($value) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="error"><?= $errors["payment"] ?? "" ?></span>
    </div>

    <div>
        <label>
            <input type="checkbox" name="agreed" value="yes"
                <?= ($formData["agreed"] ?? "") === "yes" ? "checked" : "" ?>>
            Хотите ли вы получать рассылку о конференции?
        </label>
    </div>

    <div>
        <button type="submit">Отправить</button>
    </div>
</form>

</body>
</html>
<?php elseif ($showSuccess): ?>
    <p class="success">Регистрация успешна!</p>
    <p><a href="global.php">Вернуться к форме</a></p>
<?php endif; ?>
