<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ЛР4 - API hh.ru</title>
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
            background: #ffe6e6;
            color: red;
            padding: 10px;
            border-left: 4px solid red;
            margin: 20px 0;
        }
        .success {
            background: #e6ffe6;
            color: green;
            padding: 10px;
            border-left: 4px solid green;
            margin: 20px 0;
        }
        .box {
            background: #f9f9f9;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #0066cc;
            border-radius: 5px;
        }
        .api-box {
            background: #f0f8ff;
            border-left: 4px solid #ff9900;
        }
        .user-box {
            background: #fff3e0;
            border-left: 4px solid #ff6600;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
            max-height: 300px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        td:first-child {
            font-weight: bold;
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1> Лабораторная работа №4</h1>
        <p style="text-align: center;">Вариант 1: API hh.ru/areas (список стран и городов)</p>
        
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
                <p> <?= $_SESSION['success'] ?></p>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <!-- Данные студента -->
        <?php if (isset($_SESSION['student'])): ?>
        <div class="box">
            <h3> Данные студента:</h3>
            <table>
                <tr><td>ФИО:</td><td><?= $_SESSION['student']['fullname'] ?></td></tr>
                <tr><td>Возраст:</td><td><?= $_SESSION['student']['age'] ?> лет</td></tr>
                <tr><td>Страна:</td><td><?= $_SESSION['student']['country'] ?></td></tr>
                <tr><td>Факультет:</td><td><?= $_SESSION['student']['faculty'] ?></td></tr>
                <tr><td>Форма обучения:</td><td><?= $_SESSION['student']['education'] ?></td></tr>
                <tr><td>Email:</td><td><?= $_SESSION['student']['email'] ?></td></tr>
                <tr><td>Время:</td><td><?= $_SESSION['student']['timestamp'] ?></td></tr>
            </table>
        </div>
        <?php endif; ?>
        
        <!-- Данные из API -->
        <?php if (isset($_SESSION['api_data'])): ?>
        <div class="box api-box">
            <h3> Данные из API hh.ru:</h3>
            <p><strong>URL:</strong> <?= $_SESSION['api_data']['url'] ?></p>
            <p><strong>Время запроса:</strong> <?= $_SESSION['api_data']['time'] ?></p>
            
            <?php 
            $apiData = $_SESSION['api_data']['data'];
            if (isset($apiData['error'])): ?>
                <p style="color: red;">Ошибка: <?= $apiData['message'] ?></p>
            <?php else: ?>
                <p><strong>Всего стран:</strong> <?= count($apiData) ?></p>
                
                <details>
                    <summary>Показать первые 5 стран с городами</summary>
                    <?php for($i = 0; $i < min(5, count($apiData)); $i++): 
                        $country = $apiData[$i]; ?>
                        <h4><?= $country['name'] ?></h4>
                        <ul>
                        <?php foreach(array_slice($country['areas'], 0, 5) as $city): ?>
                            <li><?= $city['name'] ?></li>
                        <?php endforeach; ?>
                        <?php if(count($country['areas']) > 5): ?>
                            <li>... и ещё <?= count($country['areas']) - 5 ?> городов</li>
                        <?php endif; ?>
                        </ul>
                    <?php endfor; ?>
                </details>
                
                <details>
                    <summary>Показать полный ответ API</summary>
                    <pre><?php print_r($apiData); ?></pre>
                </details>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <!-- Информация о пользователе -->
        <?php if (isset($_SESSION['user_info'])): ?>
        <div class="box user-box">
            <h3> Информация о пользователе (класс UserInfo):</h3>
            <table>
                <tr><td>IP:</td><td><?= $_SESSION['user_info']['ip'] ?></td></tr>
                <tr><td>Браузер:</td><td><?= $_SESSION['user_info']['browser'] ?></td></tr>
                <tr><td>ОС:</td><td><?= $_SESSION['user_info']['os'] ?></td></tr>
                <tr><td>User Agent:</td><td><small><?= $_SESSION['user_info']['user_agent'] ?></small></td></tr>
                <tr><td>Время:</td><td><?= $_SESSION['user_info']['time'] ?></td></tr>
            </table>
        </div>
        <?php endif; ?>
        
        <!-- Куки -->
        <div class="box user-box">
            <h3> Cookie:</h3>
            <?php if (isset($_COOKIE['last_submission'])): ?>
                <p><strong>Последняя отправка формы:</strong> <?= $_COOKIE['last_submission'] ?></p>
            <?php else: ?>
                <p>Кука last_submission ещё не установлена</p>
            <?php endif; ?>
            
            <details>
                <summary>Все куки</summary>
                <pre><?php print_r($_COOKIE); ?></pre>
            </details>
        </div>
        
        <!-- Информация о Composer -->
        <div class="box" style="background: #f0f0f0;">
            <h3> Информация о проекте:</h3>
            <p><strong>Composer:</strong> установлен</p>
            <p><strong>Библиотеки:</strong> guzzlehttp/guzzle</p>
            <p><strong>Классы:</strong> ApiClient, UserInfo</p>
            <p><strong>API:</strong> hh.ru/areas (вариант 1)</p>
        </div>
    </div>
</body>
</html>