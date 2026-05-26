<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/src/db.php";
require_once __DIR__ . "/src/session.php";
require_once __DIR__ . "/src/submission.php";

$config = require __DIR__ . "/config.php";
$database = new Database(
    $config["db"]["host"],
    $config["db"]["dbname"],
    $config["db"]["username"],
    $config["db"]["password"],
    $config["db"]["charset"],
);
Submission::setDatabase($database);

$session = new Session();

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["checkedItem"])) {
    Submission::markDeleted($_POST["checkedItem"]);
    $session->put("admin_message", "Выбранные заявки помечены как удалённые.");
    header("Location: admin.php");
    exit();
}

$message = $session->pull("admin_message");
$activeSubmissions = Submission::getActiveSubmissions();

require __DIR__ . "/views/admin.php";
