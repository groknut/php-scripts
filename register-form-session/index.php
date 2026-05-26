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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submission = new Submission($_POST);
    $errors = $submission->validate();

    if (empty($errors)) {
        $submission->save();
        $session->put("success", "Регистрация успешна!");
        header("Location: index.php");
        exit();
    } else {
        $session->put("form_data", $_POST);
        $session->put("form_errors", $errors);
        header("Location: index.php");
        exit();
    }
}

$successMessage = $session->pull("success");
$formData = $session->pull("form_data") ?? [];
$errors = $session->pull("form_errors") ?? [];

if ($successMessage) {
    require __DIR__ . "/views/success.php";
} else {
    require __DIR__ . "/views/form.php";
}
