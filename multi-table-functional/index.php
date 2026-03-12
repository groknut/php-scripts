
<head>
    <link rel="stylesheet" href="assets/style.css">
</head>

<div>
<h3>Таблица умножения (функциональный способ)</h3>

<?php function genMultiTable( int $x = 10, int $y = 10 ): string {

    $html = "<table>";

    for ($row = 1; $row <= $y; $row++) {
        $html .= "<tr>";
        for ($col = 1; $col <= $x; $col++) {
            $res = $row * $col;
            $class = '';
            if ($row === 1 || $col === 1) {
                $class = "header";
            }
            elseif ($row === $col) {
                $class = "diagonal";
            }

            $html .= "<td class='$class'>$res</td>";
        }
        $html .= "</tr>";
    }

    $html .= "</table>";
    return $html;

}

echo genMultiTable(12, 12)
?>
</div>
