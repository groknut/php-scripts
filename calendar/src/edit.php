<?php
session_start();

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/task.php";
require_once __DIR__ . "/helpers.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$task = Task::getById($dbo, $id);

if (!$task) {
    die('Задача не найдена. <a href="index.php">Вернуться</a>');
}

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $updatedData = [
        "id" => $task->getId(),
        "title" => trim($_POST["title"] ?? ""),
        "type" => $_POST["type"] ?? "",
        "location" => trim($_POST["location"] ?? ""),
        "task_date" => $_POST["task_date"] ?? "",
        "task_time" => $_POST["task_time"] ?? "",
        "duration" => $_POST["duration"] ?? "",
        "comment" => trim($_POST["comment"] ?? ""),
        "is_completed" => isset($_POST["is_completed"]) ? 1 : 0,
    ];

    $updatedTask = new Task($updatedData);
    $errors = $updatedTask->validate();

    if (empty($errors)) {
        if ($updatedTask->save($dbo)) {
            setFlash("success", true);
            redirect("edit.php?id=" . $task->getId());
        }
        $errors[] = "Не удалось обновить задачу.";
    }
    $task = $updatedTask;
}

if (hasFlash("success")) {
    $success = getFlash("success");
}

$dt = strtotime($task->getTaskDatetime());
$taskDate = date("Y-m-d", $dt);
$taskTime = date("H:i", $dt);

$taskTypes = getTaskTypes();
$durations = getDurations();

include __DIR__ . "/views/edit.php";
