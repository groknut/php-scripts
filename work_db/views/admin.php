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
                        <th>Дата создания</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activeSubmissions as $sub): ?>
                    <tr>
                        <td><input type="checkbox" name="checkedItem[]" value="<?= $sub[
                            "id"
                        ] ?>"></td>
                        <td><?= htmlspecialchars($sub["name"]) ?></td>
                        <td><?= htmlspecialchars($sub["lastname"]) ?></td>
                        <td><?= htmlspecialchars($sub["email"]) ?></td>
                        <td><?= htmlspecialchars($sub["tel"]) ?></td>
                        <td><?= htmlspecialchars($sub["subject_name"]) ?></td>
                        <td><?= htmlspecialchars($sub["payment_name"]) ?></td>
                        <td><?= $sub["mailing"] ? "Да" : "Нет" ?></td>
                        <td><?= htmlspecialchars($sub["created_at"]) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <button type="submit">Удалить выбранные</button>
        </form>
    <?php endif; ?>
    <p><a href="index.php">Вернуться к форме регистрации</a></p>
</body>
</html>
