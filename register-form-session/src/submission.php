<?php

class Submission
{
    public string $name;
    public string $lastname;
    public string $email;
    public string $phone;
    public string $topic;
    public string $payment;
    public string $agreed = "no";

    private const SEPARATOR = "|";

    private static string $filePath;

    public static function setFilePath(string $path): void
    {
        self::$filePath = $path;
    }

    public function __construct(array $data = [])
    {
        $this->name = $data["name"] ?? "";
        $this->lastname = $data["lastname"] ?? "";
        $this->email = $data["email"] ?? "";
        $this->phone = $data["phone"] ?? "";
        $this->topic = $data["topic"] ?? "";
        $this->payment = $data["payment"] ?? "";
        $this->agreed = !empty($data["agreed"]) ? $data["agreed"] : "no";
    }

    public function validate(): array
    {
        $errors = [];
        $digits = preg_replace("/\D/", "", $this->phone);
        $emailPattern = "/^[A-Za-z0-9._\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/";

        if (empty($this->name)) {
            $errors["name"] = "Поле с именем обязательно к заполнению!";
        } elseif (strpos($this->name, self::SEPARATOR) !== false) {
            $errors["name"] =
                "Имя не должно содержать символ '" . self::SEPARATOR . "'";
        }

        if (empty($this->lastname)) {
            $errors["lastname"] = "Поле с фамилией обязательно к заполнению!";
        } elseif (strpos($this->lastname, self::SEPARATOR) !== false) {
            $errors["lastname"] =
                "Фамилия не должна содержать символ '" . self::SEPARATOR . "'";
        }

        if (empty($this->email)) {
            $errors["email"] =
                "Поле с адресом электронной почты обязательно к заполнению!";
        } elseif (!preg_match($emailPattern, $this->email)) {
            $errors["email"] = "Ошибка в написании адреса электронной почты!";
        } elseif (strpos($this->email, self::SEPARATOR) !== false) {
            $errors["email"] =
                "Почта не должна содержать символ '" . self::SEPARATOR . "'";
        }

        if (empty($this->phone)) {
            $errors["phone"] = "Поле с телефоном обязательно к заполнению!";
        } elseif (strlen($digits) !== 11 || !in_array($digits[0], ["7", "8"])) {
            $errors["phone"] = "Неверный формат номера телефона!";
        } elseif (strpos($this->phone, self::SEPARATOR) !== false) {
            $errors["phone"] =
                "Телефон не должен содержать символ '" . self::SEPARATOR . "'";
        }

        if (empty($this->topic)) {
            $errors["topic"] = "Поле с темой обязательно к заполнению!";
        }

        if (empty($this->payment)) {
            $errors["payment"] =
                "Поле с методом оплаты обязательно к заполнению!";
        }

        if (!in_array($this->agreed, ["yes", "no"], true)) {
            $errors["agreed"] = "Некорректное значение согласия";
        }

        return $errors;
    }

    public function save(): void
    {
        $datetime = new DateTime()->format("Y-m-d H:i:s");
        $ip = $_SERVER["REMOTE_ADDR"] ?? (getenv("REMOTE_ADDR") ?: "127.0.0.1");

        $fields = [
            str_replace(self::SEPARATOR, "", $this->name),
            str_replace(self::SEPARATOR, "", $this->lastname),
            str_replace(self::SEPARATOR, "", $this->email),
            str_replace(self::SEPARATOR, "", $this->phone),
            $this->topic,
            $this->payment,
            $this->agreed,
            $datetime,
            $ip,
            "active",
        ];

        $line = implode(self::SEPARATOR, $fields) . PHP_EOL;

        if (!is_dir(dirname(self::$filePath))) {
            mkdir(dirname(self::$filePath), 0777, true);
        }

        file_put_contents(self::$filePath, $line, FILE_APPEND | LOCK_EX);
    }

    public static function getActiveSubmissions(): array
    {
        if (!file_exists(self::$filePath)) {
            return [];
        }

        $lines = file(
            self::$filePath,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES,
        );
        $active = [];

        foreach ($lines as $index => $line) {
            $fields = explode(self::SEPARATOR, $line);
            if (count($fields) >= 10 && ($fields[9] ?? "") === "active") {
                $fields["_index"] = $index;
                $active[] = $fields;
            }
        }

        return $active;
    }

    public static function markDeleted(array $indices): void
    {
        if (!file_exists(self::$filePath)) {
            return;
        }

        $lines = file(
            self::$filePath,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES,
        );
        foreach ($lines as $index => &$line) {
            if (in_array((string) $index, $indices, true)) {
                $fields = explode(self::SEPARATOR, $line);
                if (count($fields) >= 10) {
                    $fields[9] = "deleted";
                    $line = implode(self::SEPARATOR, $fields);
                }
            }
        }
        unset($line);

        file_put_contents(
            self::$filePath,
            implode(PHP_EOL, $lines) . PHP_EOL,
            LOCK_EX,
        );
    }
}
