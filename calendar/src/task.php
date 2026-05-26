<?php

class Task
{
    private ?int $id;
    private string $title;
    private string $type;
    private string $location;
    private string $taskDatetime;
    private int $duration;
    private string $comment;
    private bool $isCompleted;

    public function __construct(array $data = [])
    {
        $this->id = isset($data["id"]) ? (int) $data["id"] : null;
        $this->title = $data["title"] ?? "";
        $this->type = $data["type"] ?? "";
        $this->location = $data["location"] ?? "";

        if (isset($data["task_date"]) && isset($data["task_time"])) {
            $this->taskDatetime =
                $data["task_date"] . " " . $data["task_time"] . ":00";
        } else {
            $this->taskDatetime = $data["task_datetime"] ?? "";
        }

        $this->duration = isset($data["duration"])
            ? (int) $data["duration"]
            : 60;
        $this->comment = $data["comment"] ?? "";
        $this->isCompleted = isset($data["is_completed"])
            ? (bool) $data["is_completed"]
            : false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getType(): string
    {
        return $this->type;
    }
    public function getLocation(): string
    {
        return $this->location;
    }
    public function getTaskDatetime(): string
    {
        return $this->taskDatetime;
    }
    public function getDuration(): int
    {
        return $this->duration;
    }
    public function getComment(): string
    {
        return $this->comment;
    }
    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    public function validate(): array
    {
        $errors = [];
        if (empty($this->title)) {
            $errors[] = "Введите тему задачи";
        }
        $allowedTypes = ["Встреча", "Звонок", "Совещание", "Дело"];
        if (!in_array($this->type, $allowedTypes, true)) {
            $errors[] = "Выберите корректный тип задачи";
        }
        if (empty($this->taskDatetime) || strlen($this->taskDatetime) < 19) {
            $errors[] = "Укажите корректную дату и время";
        }
        if ($this->duration <= 0) {
            $errors[] = "Выберите длительность";
        }
        return $errors;
    }

    public function save(PDO $dbo): bool
    {
        if ($this->id) {
            $stmt = $dbo->prepare('
                UPDATE tasks SET
                    title = :title, type = :type, location = :location,
                    task_datetime = :task_datetime, duration = :duration,
                    comment = :comment, is_completed = :is_completed
                WHERE id = :id
            ');
            return $stmt->execute([
                ":id" => $this->id,
                ":title" => $this->title,
                ":type" => $this->type,
                ":location" => $this->location,
                ":task_datetime" => $this->taskDatetime,
                ":duration" => $this->duration,
                ":comment" => $this->comment,
                ":is_completed" => $this->isCompleted ? 1 : 0,
            ]);
        } else {
            $stmt = $dbo->prepare('
                INSERT INTO tasks (title, type, location, task_datetime, duration, comment, is_completed)
                VALUES (:title, :type, :location, :task_datetime, :duration, :comment, 0)
            ');
            return $stmt->execute([
                ":title" => $this->title,
                ":type" => $this->type,
                ":location" => $this->location,
                ":task_datetime" => $this->taskDatetime,
                ":duration" => $this->duration,
                ":comment" => $this->comment,
            ]);
        }
    }

    public static function getById(PDO $dbo, int $id): ?self
    {
        $stmt = $dbo->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $data = $stmt->fetch();
        return $data ? new self($data) : null;
    }

    public static function loadList(
        PDO $dbo,
        string $filter,
        ?string $dateFilter,
    ): array {
        $sql = "SELECT * FROM tasks WHERE 1=1";
        $params = [];

        if ($filter === "current") {
            $sql .= " AND is_completed = 0 AND task_datetime >= CURDATE()";
        } elseif ($filter === "overdue") {
            $sql .= " AND is_completed = 0 AND task_datetime < CURDATE()";
        } elseif ($filter === "completed") {
            $sql .= " AND is_completed = 1";
        }

        if (
            $dateFilter !== null &&
            preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFilter)
        ) {
            $sql .= " AND DATE(task_datetime) = :exact_date";
            $params[":exact_date"] = $dateFilter;
        }

        $sql .= " ORDER BY task_datetime ASC";

        $stmt = $dbo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        $tasks = [];
        foreach ($rows as $row) {
            $tasks[] = new self($row);
        }
        return $tasks;
    }
}
