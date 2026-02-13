<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все регистрации</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        h1 {
            color: #333;
            text-align: center;
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
            padding: 12px;
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
        .nav a:hover {
            background: #0052a3;
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
                echo "<th>Факультет</th>";
                echo "<th>Форма обучения</th>";
                echo "<th>Email</th>";
                echo "</tr>";
                
                foreach ($lines as $index => $line) {
                    $data = explode(";", $line);
                    // $data[0] - fullname, [1] - age, [2] - faculty, [3] - education, [4] - email
                    echo "<tr>";
                    echo "<td>" . ($index + 1) . "</td>";
                    echo "<td>" . htmlspecialchars($data[0] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($data[1] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($data[2] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($data[3] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($data[4] ?? '') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='text-align: center; color: #888; padding: 40px;'> Файл пуст. Нет зарегистрированных студентов.</p>";
            }
        } else {
            echo "<p style='text-align: center; color: #888; padding: 40px;'> Файл data.txt ещё не создан. Заполните форму!</p>";
        }
        ?>
        
        <div class="nav">
            <a href="index.php"> На главную</a>
            <a href="form.html"> Добавить студента</a>
        </div>
    </div>
</body>
</html>