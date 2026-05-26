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
$subjects = Submission::getSubjects();
$payments = Submission::getPayments();

if ($successMessage) {
    require __DIR__ . "/views/success.php";
} else {
    require __DIR__ . "/views/form.php";
}
