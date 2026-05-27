<?php
session_start();

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/task.php";
require_once __DIR__ . "/helpers.php";

$success = hasFlash("success") ? getFlash("success") : false;

$stored = getStoredFormData();
$formData = $stored["data"];
$errors = $stored["errors"];

if (empty($formData) && empty($errors)) {
    $formData["task_date"] = date("Y-m-d");
    $formData["task_time"] = date("H:00", strtotime("+1 hour"));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $task = new Task([
        "title" => trim($_POST["title"] ?? ""),
        "type" => $_POST["type"] ?? "",
        "location" => trim($_POST["location"] ?? ""),
        "task_date" => $_POST["task_date"] ?? "",
        "task_time" => $_POST["task_time"] ?? "",
        "duration" => $_POST["duration"] ?? "",
        "comment" => trim($_POST["comment"] ?? ""),
    ]);

    $errors = $task->validate();

    if (empty($errors)) {
        if ($task->save($dbo)) {
            setFlash("success", true);
            redirect("index.php");
        }
        $errors[] = "Ошибка при сохранении задачи в БД.";
    }

    storeFormData($_POST, $errors);
    redirect("index.php");
}

$filter = $_GET["filter"] ?? "current";
$exactDate = $_GET["exact_date"] ?? null;

$tasks = Task::loadList($dbo, $filter, $exactDate);

$taskTypes = getTaskTypes();
$durations = getDurations();

include __DIR__ . "/views/index.php";
