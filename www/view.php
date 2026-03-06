<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все зарегистрированные студенты</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 20px;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 32px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }

        .count {
            text-align: right;
            color: #666;
            margin-bottom: 20px;
            font-size: 16px;
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            display: inline-block;
            float: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0 30px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 10px;
            font-weight: 600;
            text-align: left;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e0e0e0;
            color: #555;
            font-size: 14px;
        }

        tr:hover {
            background: #f8f9fa;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .nav {
            text-align: center;
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .nav a {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .nav a:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .empty-message {
            text-align: center;
            color: #888;
            padding: 60px;
            font-size: 18px;
            background: #f8f9fa;
            border-radius: 10px;
            margin: 20px 0;
        }

        /* Фиксированная ширина колонок */
        th:nth-child(1) { width: 5%; }   /* № */
        th:nth-child(2) { width: 15%; }  /* ФИО */
        th:nth-child(3) { width: 8%; }   /* Возраст */
        th:nth-child(4) { width: 10%; }  /* Страна */
        th:nth-child(5) { width: 15%; }  /* Факультет */
        th:nth-child(6) { width: 8%; }   /* Форма */
        th:nth-child(7) { width: 20%; }  /* Email */
        th:nth-child(8) { width: 19%; }  /* Время */

        /* Выравнивание текста */
        td:nth-child(1) { text-align: center; }
        td:nth-child(3) { text-align: center; }
        td:nth-child(6) { text-align: center; }
        
        /* Перенос длинных email */
        td:nth-child(7) {
            word-break: break-all;
            font-size: 13px;
        }

        .clear {
            clear: both;
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
                echo "<div class='count'> Всего записей: <strong>$count</strong></div>";
                echo "<div class='clear'></div>";
                
                echo "<table>";
                echo "<tr>";
                echo "<th>№</th>";
                echo "<th>ФИО</th>";
                echo "<th>Возраст</th>";
                echo "<th>Страна</th>";
                echo "<th>Факультет</th>";
                echo "<th>Форма</th>";
                echo "<th>Email</th>";
                echo "<th>Время регистрации</th>";
                echo "</tr>";
                
                foreach ($lines as $index => $line) {
                    $data = explode(";", $line);
                    // Проверяем, что данных достаточно
                    if (count($data) >= 7) {
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
                }
                echo "</table>";
            } else {
                echo "<div class='empty-message'> Файл пуст. Нет зарегистрированных студентов.</div>";
            }
        } else {
            echo "<div class='empty-message'> Файл data.txt ещё не создан. Заполните форму!</div>";
        }
        ?>
        
        <div class="nav">
            <a href="index.php"> На главную</a>
            <a href="form.html"> Добавить студента</a>
        </div>
    </div>
</body>
</html>