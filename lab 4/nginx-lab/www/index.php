<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР4 - API hh.ru</title>
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
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
            font-size: 32px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 18px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }

        .nav {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin: 30px 0;
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

        .message {
            padding: 15px 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-weight: 500;
        }

        .error {
            background: #ffebee;
            border-left: 4px solid #f44336;
            color: #c62828;
        }

        .success {
            background: #e8f5e8;
            border-left: 4px solid #4CAF50;
            color: #2e7d32;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }

        .card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            border-left: 4px solid #667eea;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 20px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .card table {
            width: 100%;
        }

        .card td {
            padding: 8px 0;
            color: #555;
        }

        .card td:first-child {
            font-weight: 600;
            color: #333;
            width: 120px;
        }

        .cookie-card {
            border-left-color: #ff9800;
        }

        .api-card {
            border-left-color: #2196F3;
        }

        .info-card {
            border-left-color: #9C27B0;
        }

        pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 10px;
            overflow-x: auto;
            font-size: 13px;
            max-height: 300px;
        }

        details {
            margin-top: 15px;
        }

        summary {
            color: #667eea;
            font-weight: 600;
            cursor: pointer;
            padding: 5px;
        }

        summary:hover {
            text-decoration: underline;
        }

        .cookie-value {
            background: #fff3e0;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            background: #e0e0e0;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            color: #333;
            margin-left: 10px;
        }

        .project-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
        }

        .project-info h3 {
            color: white;
            border-bottom-color: rgba(255,255,255,0.3);
        }

        .project-info .badge {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .project-info td {
            color: white;
        }

        .project-info td:first-child {
            color: rgba(255,255,255,0.8);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1> Лабораторная работа №4</h1>
        <div class="subtitle">Вариант 1: API hh.ru/areas (список стран и городов)</div>
        
        <div class="nav">
            <a href="form.html"> Заполнить форму</a>
            <a href="view.php"> Все регистрации</a>
        </div>
        
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="message error">
                <strong> Ошибки:</strong>
                <ul style="margin-top: 10px; margin-left: 20px;">
                <?php foreach($_SESSION['errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="message success">
                 <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <div class="grid">
            <!-- Данные студента -->
            <?php if (isset($_SESSION['student'])): ?>
            <div class="card">
                <h3> Данные студента</h3>
                <table>
                    <tr><td>ФИО:</td><td><?= htmlspecialchars($_SESSION['student']['fullname'] ?? '') ?></td></tr>
                    <tr><td>Возраст:</td><td><?= htmlspecialchars($_SESSION['student']['age'] ?? '') ?> лет</td></tr>
                    <tr><td>Страна:</td><td><?= htmlspecialchars($_SESSION['student']['country'] ?? '') ?></td></tr>
                    <tr><td>Факультет:</td><td><?= htmlspecialchars($_SESSION['student']['faculty'] ?? '') ?></td></tr>
                    <tr><td>Форма:</td><td><?= htmlspecialchars($_SESSION['student']['education'] ?? '') ?></td></tr>
                    <tr><td>Email:</td><td><?= htmlspecialchars($_SESSION['student']['email'] ?? '') ?></td></tr>
                    <tr><td>Время:</td><td><?= htmlspecialchars($_SESSION['student']['timestamp'] ?? '') ?></td></tr>
                </table>
            </div>
            <?php endif; ?>
            
            <!-- Cookie -->
            <div class="card cookie-card">
                <h3> Cookie</h3>
                <?php if (isset($_COOKIE['last_submission'])): ?>
                    <div class="cookie-value">
                        <strong>Последняя отправка формы:</strong><br>
                        <?= htmlspecialchars($_COOKIE['last_submission']) ?>
                    </div>
                <?php else: ?>
                    <p style="color: #888;">Кука last_submission ещё не установлена</p>
                <?php endif; ?>
                
                <details>
                    <summary>Все куки</summary>
                    <pre><?php print_r($_COOKIE); ?></pre>
                </details>
            </div>
        </div>
        
        <!-- Информация о проекте -->
        <div class="project-info">
            <h3> Информация о проекте</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
                <div>
                    <strong>Composer:</strong> <span class="badge">установлен</span>
                </div>
                <div>
                    <strong>Библиотеки:</strong> <span class="badge">guzzlehttp/guzzle</span>
                </div>
                <div>
                    <strong>Классы:</strong> <span class="badge">ApiClient</span> <span class="badge">UserInfo</span>
                </div>
                <div>
                    <strong>API:</strong> <span class="badge">hh.ru/areas (вариант 1)</span>
                </div>
            </div>
        </div>
        
        <!-- Данные из API (если есть) -->
        <?php if (isset($_SESSION['api_data'])): ?>
        <div style="margin-top: 30px;">
            <div class="card api-card">
                <h3> Данные из API hh.ru</h3>
                <p><strong>Время запроса:</strong> <?= htmlspecialchars($_SESSION['api_data']['time'] ?? '') ?></p>
                
                <?php 
                $apiData = $_SESSION['api_data']['data'] ?? [];
                if (isset($apiData['error'])): ?>
                    <p style="color: #f44336;"> Ошибка: <?= htmlspecialchars($apiData['message']) ?></p>
                <?php else: ?>
                    <p><strong>Всего стран:</strong> <?= count($apiData) ?></p>
                    
                    <details>
                        <summary>Показать первые 5 стран</summary>
                        <div style="margin-top: 15px;">
                        <?php for($i = 0; $i < min(5, count($apiData)); $i++): 
                            $country = $apiData[$i]; ?>
                            <div style="margin-bottom: 15px; padding: 10px; background: #f0f0f0; border-radius: 5px;">
                                <strong><?= htmlspecialchars($country['name'] ?? '') ?></strong>
                                <?php if (!empty($country['areas'])): ?>
                                    <ul style="margin-top: 5px; margin-left: 20px;">
                                    <?php foreach(array_slice($country['areas'], 0, 5) as $city): ?>
                                        <li><?= htmlspecialchars($city['name'] ?? '') ?></li>
                                    <?php endforeach; ?>
                                    <?php if(count($country['areas']) > 5): ?>
                                        <li>... и ещё <?= count($country['areas']) - 5 ?> городов</li>
                                    <?php endif; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                        </div>
                    </details>
                    
                    <details>
                        <summary>Показать полный ответ API</summary>
                        <pre><?php print_r($apiData); ?></pre>
                    </details>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Информация о пользователе -->
        <?php if (isset($_SESSION['user_info'])): ?>
        <div style="margin-top: 30px;">
            <div class="card">
                <h3> Информация о пользователе</h3>
                <table>
                    <tr><td>IP:</td><td><?= htmlspecialchars($_SESSION['user_info']['ip'] ?? '') ?></td></tr>
                    <tr><td>Браузер:</td><td><?= htmlspecialchars($_SESSION['user_info']['browser'] ?? '') ?></td></tr>
                    <tr><td>ОС:</td><td><?= htmlspecialchars($_SESSION['user_info']['os'] ?? '') ?></td></tr>
                    <tr><td>Время:</td><td><?= htmlspecialchars($_SESSION['user_info']['time'] ?? '') ?></td></tr>
                    <tr><td>User Agent:</td><td><small><?= htmlspecialchars($_SESSION['user_info']['user_agent'] ?? '') ?></small></td></tr>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>