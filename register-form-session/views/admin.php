<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Администрирование заявок</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .message { color: green; }
    </style>
</head>
<body>
    <h1>Заявки на конференцию (активные)</h1>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

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
                        <td><?= ($sub[6] ?? "") === "yes" ? "Да" : "Нет" ?></td>
                        <td><?= htmlspecialchars($sub[7] ?? "") ?></td>
                        <td><?= htmlspecialchars($sub[8] ?? "") ?></td>
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
