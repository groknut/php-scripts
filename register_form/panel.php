<?php
$dataDir = "./data";
$allowedPattern = '/^file_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}$/';

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["checkedItem"])) {
    foreach ($_POST["checkedItem"] as $id) {
        $safeId = basename($id);
        if (preg_match($allowedPattern, $safeId)) {
            $file = $dataDir . "/" . $safeId . ".txt";
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
    header("Location: admin.php");
    exit();
}

$items = [];
foreach (glob($dataDir . "/file_*.txt") as $file) {
    $id = basename($file, ".txt");
    if (preg_match($allowedPattern, $id)) {
        $items[$id] = file_get_contents($file);
    }
}
?>
<html>
    <body>
        <h1>Admin</h1>
        <form action="" method="POST">
            <ul>
                <?php foreach ($items as $id => $item): ?>
                    <li>
                        <label>
                            <input type="checkbox" name="checkedItem[]" value="<?= htmlspecialchars(
                                $id,
                            ) ?>">
                            <b><?= htmlspecialchars($id) ?></b>
                        </label>
                        <br>
                        <?= nl2br(htmlspecialchars($item)) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button type="submit">Удалить выбранные</button>
        </form>
    </body>
</html>
