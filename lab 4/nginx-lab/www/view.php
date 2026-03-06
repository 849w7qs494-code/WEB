<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Все регистрации</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background: #0066cc;
            color: white;
            padding: 12px;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .nav {
            text-align: center;
            margin-top: 20px;
        }
        .nav a {
            display: inline-block;
            background: #0066cc;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .count {
            text-align: right;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1> Все зарегистрированные студенты</h1>
        
        <?php
        if (file_exists("data.txt")) {
            $lines = file("data.txt", FILE_IGNORE_NEW_LINES);
            $count = count($lines);
            
            if ($count > 0) {
                echo "<p class='count'>Всего записей: $count</p>";
                echo "<table>";
                echo "<tr>";
                echo "<th>№</th>";
                echo "<th>ФИО</th>";
                echo "<th>Возраст</th>";
                echo "<th>Страна</th>";
                echo "<th>Факультет</th>";
                echo "<th>Форма</th>";
                echo "<th>Email</th>";
                echo "<th>Время</th>";
                echo "</tr>";
                
                foreach ($lines as $index => $line) {
                    $data = explode(";", $line);
                    echo "<tr>";
                    echo "<td>" . ($index + 1) . "</td>";
                    echo "<td>" . htmlspecialchars($data[0] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($data[1] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($data[2] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($data[3] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($data[4] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($data[5] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($data[6] ?? '') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='text-align: center; padding: 40px;'>Нет записей</p>";
            }
        } else {
            echo "<p style='text-align: center; padding: 40px;'>Файл data.txt не найден</p>";
        }
        ?>
        
        <div class="nav">
            <a href="index.php">На главную</a>
            <a href="form.html">Добавить</a>
        </div>
    </div>
</body>
</html>