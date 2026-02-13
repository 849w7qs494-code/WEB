<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР3 - Регистрация студентов</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 800px;
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
        .nav {
            text-align: center;
            margin: 20px 0;
        }
        .nav a {
            display: inline-block;
            background: #0066cc;
            color: white;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .nav a:hover {
            background: #0052a3;
        }
        .error {
            color: red;
            background: #ffe6e6;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid red;
            margin: 20px 0;
        }
        .success {
            color: green;
            background: #e6ffe6;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid green;
            margin: 20px 0;
        }
        .data-box {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #0066cc;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1> Лабораторная работа №3</h1>
        <p style="text-align: center;">Обработка формы через PHP + Сессии + Файлы</p>
        
        <div class="nav">
            <a href="form.html"> Заполнить форму</a>
            <a href="view.php"> Все регистрации</a>
        </div>
        
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="error">
                <h3> Ошибки:</h3>
                <ul>
                <?php foreach($_SESSION['errors'] as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success">
                <p><?= $_SESSION['success'] ?></p>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <div class="data-box">
            <h3> Текущие данные в сессии:</h3>
            <?php if (isset($_SESSION['student'])): ?>
                <ul>
                    <li><strong>ФИО:</strong> <?= $_SESSION['student']['fullname'] ?></li>
                    <li><strong>Возраст:</strong> <?= $_SESSION['student']['age'] ?> лет</li>
                    <li><strong>Факультет:</strong> <?= $_SESSION['student']['faculty'] ?></li>
                    <li><strong>Форма обучения:</strong> <?= $_SESSION['student']['education'] ?></li>
                    <li><strong>Email:</strong> <?= $_SESSION['student']['email'] ?></li>
                </ul>
            <?php else: ?>
                <p style="color: #888;">Нет данных в сессии. Заполните форму!</p>
            <?php endif; ?>
        </div>
        
        <p style="text-align: center; color: #666; margin-top: 30px;">
            После отправки формы данные сохраняются в сессию и в файл data.txt
        </p>
    </div>
</body>
</html>