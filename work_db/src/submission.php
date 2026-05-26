<?php

class Submission
{
    public string $name;
    public string $lastname;
    public string $email;
    public string $phone;
    public int $subjectId;
    public int $paymentId;
    public string $agreed = "no";

    private static Database $db;

    public static function setDatabase(Database $database): void
    {
        self::$db = $database;
    }

    public function __construct(array $data = [])
    {
        $this->name = $data["name"] ?? "";
        $this->lastname = $data["lastname"] ?? "";
        $this->email = $data["email"] ?? "";
        $this->phone = $data["phone"] ?? "";
        $this->subjectId = (int) ($data["subject_id"] ?? 0);
        $this->paymentId = (int) ($data["payment_id"] ?? 0);
        $this->agreed = !empty($data["agreed"]) ? $data["agreed"] : "no";
    }

    public function validate(): array
    {
        $errors = [];
        $digits = preg_replace("/\D/", "", $this->phone);
        $emailPattern = "/^[A-Za-z0-9._\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/";

        if (empty($this->name)) {
            $errors["name"] = "Поле с именем обязательно к заполнению!";
        }
        if (empty($this->lastname)) {
            $errors["lastname"] = "Поле с фамилией обязательно к заполнению!";
        }
        if (empty($this->email)) {
            $errors["email"] =
                "Поле с адресом электронной почты обязательно к заполнению!";
        } elseif (!preg_match($emailPattern, $this->email)) {
            $errors["email"] = "Ошибка в написании адреса электронной почты!";
        }
        if (empty($this->phone)) {
            $errors["phone"] = "Поле с телефоном обязательно к заполнению!";
        } elseif (strlen($digits) !== 11 || !in_array($digits[0], ["7", "8"])) {
            $errors["phone"] = "Неверный формат номера телефона!";
        }
        if (empty($this->subjectId)) {
            $errors["subject_id"] = "Выберите тему конференции!";
        } else {
            $subjects = self::getSubjects();
            if (!isset($subjects[$this->subjectId])) {
                $errors["subject_id"] = "Выбранная тема не существует!";
            }
        }
        if (empty($this->paymentId)) {
            $errors["payment_id"] = "Выберите способ оплаты!";
        } else {
            $payments = self::getPayments();
            if (!isset($payments[$this->paymentId])) {
                $errors["payment_id"] =
                    "Выбранный способ оплаты не существует!";
            }
        }
        if (!in_array($this->agreed, ["yes", "no"], true)) {
            $errors["agreed"] = "Некорректное значение согласия";
        }

        return $errors;
    }

    public function save(): void
    {
        $pdo = self::$db->getConnection();
        $sql = "INSERT INTO participants (name, lastname, email, tel, subject_id, payment_id, mailing, created_at, updated_at)
                VALUES (:name, :lastname, :email, :tel, :subject_id, :payment_id, :mailing, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "name" => $this->name,
            "lastname" => $this->lastname,
            "email" => $this->email,
            "tel" => $this->phone,
            "subject_id" => $this->subjectId,
            "payment_id" => $this->paymentId,
            "mailing" => $this->agreed === "yes" ? 1 : 0,
        ]);
    }

    public static function getActiveSubmissions(): array
    {
        $pdo = self::$db->getConnection();
        $sql = "SELECT p.*, s.name AS subject_name, pm.name AS payment_name
                FROM participants p
                LEFT JOIN subjects s ON p.subject_id = s.id
                LEFT JOIN payments pm ON p.payment_id = pm.id
                WHERE p.deleted_at IS NULL
                ORDER BY p.created_at DESC";
        return $pdo->query($sql)->fetchAll();
    }

    public static function markDeleted(array $ids): void
    {
        if (empty($ids)) {
            return;
        }
        $pdo = self::$db->getConnection();
        $placeholders = implode(",", array_fill(0, count($ids), "?"));
        $sql = "UPDATE participants SET deleted_at = NOW(), updated_at = NOW() WHERE id IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_map("intval", $ids));
    }

    public static function getSubjects(): array
    {
        $pdo = self::$db->getConnection();
        $rows = $pdo
            ->query("SELECT id, name FROM subjects ORDER BY id")
            ->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[(int) $row["id"]] = $row["name"];
        }
        return $result;
    }

    public static function getPayments(): array
    {
        $pdo = self::$db->getConnection();
        $rows = $pdo
            ->query("SELECT id, name FROM payments ORDER BY id")
            ->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[(int) $row["id"]] = $row["name"];
        }
        return $result;
    }
}
