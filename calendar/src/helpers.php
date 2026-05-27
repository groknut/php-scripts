<?php

function e(?string $value): string
{
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}

function getTaskTypes(): array
{
    return ["Встреча", "Звонок", "Совещание", "Дело"];
}

function getDurations(): array
{
    return [
        15 => "15 минут",
        30 => "30 минут",
        60 => "1 час",
        120 => "2 часа",
        240 => "4 часа",
        480 => "Весь рабочий день (8 ч)",
    ];
}

function setFlash(string $key, $value): void
{
    $_SESSION["flash_" . $key] = $value;
}

function hasFlash(string $key): bool
{
    return isset($_SESSION["flash_" . $key]);
}

function getFlash(string $key)
{
    $value = $_SESSION["flash_" . $key] ?? null;
    unset($_SESSION["flash_" . $key]);
    return $value;
}

function storeFormData(array $data, array $errors): void
{
    $_SESSION["form_data"] = $data;
    $_SESSION["form_errors"] = $errors;
}

function getStoredFormData(): array
{
    $data = $_SESSION["form_data"] ?? [];
    $errors = $_SESSION["form_errors"] ?? [];
    unset($_SESSION["form_data"], $_SESSION["form_errors"]);
    return ["data" => $data, "errors" => $errors];
}

function redirect(string $url): void
{
    header("Location: " . $url);
    exit();
}
