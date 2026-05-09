<?php
$value = "123";

if (preg_match('/^-?\d+$/', $value)) {
    echo "1. Matched";
}

$value = "text12";

if (preg_match('/^[\da-zA-Z]+$/', $value)) {
    echo "2. Matched";
}

$value = "text14окак";

if (preg_match('/^[\da-zA-ZА-Яа-яёЁ]+$/u', $value)) {
    echo "3. Matched";
}

$value = "google.com";

if (
    preg_match(
        '/^([\w\-]+\.){0,2}[a-z\d][a-z\d\-]*[a-z\d]\.[a-z]{2,16}$/i',
        $value,
    ) &&
    !preg_match("/\-\-/", $value)
) {
    echo "4. Matched";
}

$value = "Spa12";

if (preg_match('/^[a-zA-Z][\da-zA-Z]{2,24}$/', $value)) {
    echo "5. Matched";
}

$value = "fraffrsrerefawe";

if (preg_match('/^[a-zA-Z]+$/', $value)) {
    echo "6. Matched";
}

$value = "fraFF4542rerefawe!()";

if (preg_match('/^[a-zA-Z\d!@#$%^&*()_+=\-]{8,}$/', $value)) {
    echo "7. Matched";
}

$value = "2026-02-24";

if (
    preg_match('/^\d{1,4}\-(0[1-9]|1[12])\-(0[1-9]|[12][0-9]|3[01])$/', $value)
) {
    echo "8. Matched";
}

$value = "18/11/2004";

if (
    preg_match('/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[12])\/\d{1,4}$/', $value)
) {
    echo "9. Matched";
}

$value = "04.12.2016";

if (
    preg_match('/^(0[1-9]|[12][0-9]|3[01])\.(0[1-9]|1[12])\.\d{1,4}$/', $value)
) {
    echo "10. Matched";
}

$value = "23:50:01";

if (preg_match('/^(0\d|1\d|2[0-3]):[0-5]\d:[0-5]\d$/', $value)) {
    echo "11. Matched";
}

$value = "23:50";

if (preg_match('/^(0\d|1\d|2[0-3]):[0-5]\d$/', $value)) {
    echo "12. Matched";
}

$value = "https://www.yandex.ru/";

if (
    preg_match(
        '/^(http|https):\/\/([\w\-]+\.){0,2}[a-z\d][a-z\d\-]*[a-z\d]\.[a-z]{2,16}\/$/i',
        $value,
    ) &&
    !preg_match("/\-\-/", $value)
) {
    echo "13. Matched";
}

$value = "user@maildomain.com";

if (preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $value)) {
    echo "14. Matched";
}

$value = "94.137.192.210";

if (
    preg_match(
        '/^(\d|\d\d|1\d\d|2[0-5][0-5])\.(\d|\d\d|1\d\d|2[0-5][0-5])\.(\d|\d\d|1\d\d|2[0-5][0-5])\.(\d|\d\d|1\d\d|2[0-5][0-5])$/',
        $value,
    )
) {
    echo "15. Matched";
}

$value = "2001:0:9d38:6abd:c70:2d3c:a176:3398";

if (preg_match('/^([0-9a-fA-F]{1,4}:){7}[0-9a-fA-F]{1,4}$/', $value)) {
    echo "16. Matched";
}

$value = "ec:23:3d:1b:7a:e7";

if (preg_match('/^([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}$/', $value)) {
    echo "17. Matched";
}

$value = "+79021234567";

if (preg_match('/^(\+7|8)\d{10}$/', $value)) {
    echo "18. Matched";
}

$value = "4048 4323 9889 3301";

if (preg_match('/^([0-9]{4} ){3}[0-9]{4}$/', $value)) {
    echo "19. Matched";
}

$value = "380870115601";

if (preg_match('/^[0-8]\d(\d{8}|\d{10})$/', $value)) {
    echo "20. Matched";
}

$value = "664000";

if (preg_match('/^\d{6}$/', $value)) {
    echo "21. Matched";
}

$value = "1000000,00 рублей";

if (preg_match('/^[1-9]\d*\,\d{2} (руб.|р.|рублей)$/', $value)) {
    echo "22. Matched";
}

$value = '$39.99';

if (preg_match('/^\$\d+\.\d{2}$/', $value)) {
    echo "23. Matched";
}
?>
