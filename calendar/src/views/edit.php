<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Карточка задачи</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <h1>Редактирование задачи</h1>
    <p><a href="index.php">← Назад к списку</a></p>

    <div class="box">
        <?php if ($success): ?>
            <div class="success">Задача успешно обновлена!</div>
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

        <form action="edit.php?id=<?= $task->getId() ?>" method="POST">
            <div class="form-group">
                <label>Тема:</label>
                <div class="controls">
                    <input type="text" name="title" value="<?= e(
                        $task->getTitle(),
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
                            ) ?>" <?= $task->getType() === $typeOption
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
                        $task->getLocation(),
                    ) ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Дата и время:</label>
                <div class="controls short-inputs">
                    <input type="date" name="task_date" value="<?= e(
                        $taskDate,
                    ) ?>">
                    <input type="time" name="task_time" value="<?= e(
                        $taskTime,
                    ) ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Длительность:</label>
                <div class="controls" style="width: 200px;">
                    <select name="duration">
                        <?php foreach ($durations as $val => $label): ?>
                            <option value="<?= $val ?>" <?= (int) $task->getDuration() ===
$val
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
                        $task->getComment(),
                    ) ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label>Статус:</label>
                <div class="controls" style="padding-top: 5px;">
                    <label style="text-align: left; font-weight: normal; width: auto;">
                        <input type="checkbox" name="is_completed" <?= $task->isCompleted()
                            ? "checked"
                            : "" ?>>
                        Отметить как выполненную
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label></label>
                <div class="controls">
                    <button type="submit">Сохранить изменения</button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>
