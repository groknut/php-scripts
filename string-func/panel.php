<?php
define("SEPARATOR", "|");

$submissionsFile = "./data/submissions.txt";

// Обработка логического удаления (soft delete)
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["checkedItem"])) {
    $checkedIndices = $_POST["checkedItem"]; // это порядковые номера строк (индексы) начиная с 0

    if (file_exists($submissionsFile)) {
        $lines = file(
            $submissionsFile,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES,
        );
        $newLines = [];
        foreach ($lines as $index => $line) {
            $fields = explode(SEPARATOR, $line);
            if (in_array((string) $index, $checkedIndices, true)) {
                // Меняем статус на "deleted" (последнее поле)
                if (count($fields) >= 10) {
                    $fields[9] = "deleted";
                }
                $line = implode(SEPARATOR, $fields);
            }
            $newLines[] = $line;
        }
        // Перезаписываем файл
        file_put_contents(
            $submissionsFile,
            implode(PHP_EOL, $newLines) . PHP_EOL,
            LOCK_EX,
        );
    }
    header("Location: admin.php");
    exit();
}

// Чтение активных заявок
$activeSubmissions = [];
if (file_exists($submissionsFile)) {
    $lines = file(
        $submissionsFile,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES,
    );
    foreach ($lines as $index => $line) {
        $fields = explode(SEPARATOR, $line);
        // Ожидаемый формат: 0 имя, 1 фамилия, 2 email, 3 телефон, 4 тема, 5 оплата, 6 согласие, 7 дата, 8 ip, 9 статус
        if (count($fields) >= 10 && $fields[9] === "active") {
            // Добавляем индекс для чекбокса
            $fields["_index"] = $index;
            $activeSubmissions[] = $fields;
        }
    }
}

// Маппинг тем и оплат для читаемого отображения
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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Администрирование заявок</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Заявки на конференцию (активные)</h1>
    <?php if (empty($activeSubmissions)): ?>
        <p>Нет активных заявок.</p>
    <?php else: ?>
        <form action="" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Выбрать</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Тема</th>
                        <th>Оплата</th>
                        <th>Рассылка</th>
                        <th>Дата</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activeSubmissions as $sub): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="checkedItem[]" value="<?= $sub[
                                "_index"
                            ] ?>">
                        </td>
                        <td><?= htmlspecialchars($sub[0]) ?></td>
                        <td><?= htmlspecialchars($sub[1]) ?></td>
                        <td><?= htmlspecialchars($sub[2]) ?></td>
                        <td><?= htmlspecialchars($sub[3]) ?></td>
                        <td><?= htmlspecialchars(
                            $topics[$sub[4]] ?? $sub[4],
                        ) ?></td>
                        <td><?= htmlspecialchars(
                            $payments[$sub[5]] ?? $sub[5],
                        ) ?></td>
                        <td><?= $sub[6] === "yes" ? "Да" : "Нет" ?></td>
                        <td><?= htmlspecialchars($sub[7]) ?></td>
                        <td><?= htmlspecialchars($sub[8]) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <button type="submit">Удалить выбранные (пометить удалёнными)</button>
        </form>
    <?php endif; ?>
    <p><a href="index.php">Вернуться к форме регистрации</a></p>
</body>
</html>
