
<!DOCTYPE html>
<head>
    <title>Таблица умножения</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
<h3>Таблица умножения (Линейный способ)</h3>
<table>
    <?php
    $size = 10;

    for ($i = 1; $i <= $size; $i++) {
        echo "<tr>";

        for ($j = 1; $j <= $size; $j++) {
            $res = $i * $j;
            $class = '';
            if ($i === 1 || $j === 1) $class = 'header';
            elseif ($i === $j) $class = 'diagonal';
            echo "<td class='$class'>$res</td>";
        }
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
