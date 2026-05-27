<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой календарь</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <h1>Мой календарь</h1>

    <div class="block-title">Новая задача</div>
    <div class="box">
        <?php if ($success): ?>
            <div class="success">Задача успешно добавлена!</div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <div class="form-group">
                <label>Тема:</label>
                <div class="controls">
                    <input type="text" name="title" value="<?= e(
                        $formData["title"] ?? "",
                    ) ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Тип:</label>
                <div class="controls" style="width: 200px;">
                    <select name="type">
                        <?php foreach ($taskTypes as $typeOption): ?>
                            <option value="<?= e(
                                $typeOption,
                            ) ?>" <?= ($formData["type"] ?? "") === $typeOption
    ? "selected"
    : "" ?>>
                                <?= e($typeOption) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Место:</label>
                <div class="controls">
                    <input type="text" name="location" value="<?= e(
                        $formData["location"] ?? "",
                    ) ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Дата и время:</label>
                <div class="controls short-inputs">
                    <input type="date" name="task_date" value="<?= e(
                        $formData["task_date"] ?? "",
                    ) ?>">
                    <input type="time" name="task_time" value="<?= e(
                        $formData["task_time"] ?? "",
                    ) ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Длительность:</label>
                <div class="controls" style="width: 200px;">
                    <select name="duration">
                        <?php foreach ($durations as $val => $label): ?>
                            <option value="<?= $val ?>" <?= (int) ($formData[
    "duration"
] ?? 60) === $val
    ? "selected"
    : "" ?>>
                                <?= e($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Комментарий:</label>
                <div class="controls">
                    <textarea name="comment" rows="3"><?= e(
                        $formData["comment"] ?? "",
                    ) ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label></label>
                <div class="controls">
                    <button type="submit">Добавить</button>
                </div>
            </div>
        </form>
    </div>

    <div class="block-title">Список задач</div>
    <div class="box">
        <form method="GET" action="index.php" class="filters">
            <select name="filter" onchange="this.form.submit()">
                <option value="current" <?= $filter === "current"
                    ? "selected"
                    : "" ?>>Текущие задачи</option>
                <option value="overdue" <?= $filter === "overdue"
                    ? "selected"
                    : "" ?>>Просроченные задачи</option>
                <option value="completed" <?= $filter === "completed"
                    ? "selected"
                    : "" ?>>Выполненные задачи</option>
            </select>

            <input type="date" name="exact_date" value="<?= e(
                $exactDate ?? "",
            ) ?>" onchange="this.form.submit()" placeholder="Конкретная дата">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Тип</th>
                    <th>Задача</th>
                    <th>Место</th>
                    <th>Дата и время ▼</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tasks)): ?>
                    <tr><td colspan="4" style="text-align:center;">Задач не найдено</td></tr>
                <?php else: ?>
                    <?php foreach ($tasks as $t): ?>
                        <tr>
                            <td><?= e($t->getType()) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $t->getId() ?>">
                                    <?= e($t->getTitle()) ?>
                                </a>
                            </td>
                            <td><?= e($t->getLocation() ?: "-") ?></td>
                            <td><?= date(
                                "d/m/Y H:i",
                                strtotime($t->getTaskDatetime()),
                            ) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('click', () => {
                const link = row.querySelector('a');
                if (link) window.location.href = link.href;
            });
        });
    </script>


</body>
</html>
