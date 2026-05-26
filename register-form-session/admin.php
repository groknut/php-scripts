<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/src/session.php";
require_once __DIR__ . "/src/submission.php";

$config = require __DIR__ . "/config.php";
Submission::setFilePath($config["data_file"]);

$session = new Session();

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

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["checkedItem"])) {
    Submission::markDeleted($_POST["checkedItem"]);
    $session->put("admin_message", "Выбранные заявки помечены как удалённые.");
    header("Location: admin.php");
    exit();
}

$message = $session->pull("admin_message");
$activeSubmissions = Submission::getActiveSubmissions();

require __DIR__ . "/views/admin.php";
