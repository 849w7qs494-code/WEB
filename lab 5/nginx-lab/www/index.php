<?php
require 'db.php';
require 'Student.php';

$student = new Student($pdo);
$students = $student->getAll();

if (isset($_GET['delete'])) {
    $student->delete($_GET['delete']);
    header("Location: index.php");
    exit();
}

session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список студентов в БД</title>
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

        .nav a.adminer {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .errors {
            background: #ffebee;
            border-left: 4px solid #f44336;
            color: #c62828;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .errors ul {
            margin-top: 10px;
            margin-left: 20px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #f8f9fa;
            border-radius: 15px;
            margin: 30px 0;
        }

        .empty-state-icon {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .empty-state p {
            color: #888;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .empty-state a {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 40px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s;
        }

        .empty-state a:hover {
            transform: translateY(-2px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            color: #555;
        }

        tr:hover {
            background: #f8f9fa;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .delete-btn {
            color: #f44336;
            text-decoration: none;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .delete-btn:hover {
            background: #ffebee;
            text-decoration: none;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge.success {
            background: #4CAF50;
            color: white;
        }

        .badge.warning {
            background: #ff9800;
            color: white;
        }

        .table-footer {
            text-align: right;
            color: #666;
            margin-top: 10px;
            font-size: 14px;
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            table {
                font-size: 14px;
            }
            
            td, th {
                padding: 10px;
            }
            
            .nav {
                flex-direction: column;
                align-items: center;
            }
            
            .nav a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 Лабораторная работа №5</h1>
        <div class="subtitle">MySQL + PHP + Docker (Вариант 1: Регистрация студента)</div>
        
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <strong> Ошибки при добавлении:</strong>
                <ul>
                <?php foreach($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="nav">
            <a href="form.html"> Добавить студента</a>
            <a href="http://localhost:8081" target="_blank" class="adminer"> Adminer (управление БД)</a>
        </div>
        
        <h2 style="margin: 30px 0 20px; color: #333;"> Список студентов в базе данных</h2>
        
        <?php if (count($students) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ФИО</th>
                        <th>Возраст</th>
                        <th>Факультет</th>
                        <th>Форма обучения</th>
                        <th>Согласие</th>
                        <th>Дата регистрации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($students as $row): ?>
                    <tr>
                        <td style="font-weight: 600; color: #667eea;">#<?= $row['id'] ?></td>
                        <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                        <td><?= $row['age'] ?> лет</td>
                        <td><?= htmlspecialchars($row['faculty']) ?></td>
                        <td>
                            <?php if ($row['study_form'] == 'Очная'): ?>
                                <span class="badge success"> Очная</span>
                            <?php elseif ($row['study_form'] == 'Заочная'): ?>
                                <span class="badge warning"> Заочная</span>
                            <?php else: ?>
                                <span class="badge"><?= htmlspecialchars($row['study_form']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <?= $row['agree_rules'] ? '✅' : '❌' ?>
                        </td>
                        <td><?= date('d.m.Y H:i', strtotime($row['created_at'])) ?></td>
                        <td style="text-align: center;">
                            <a href="?delete=<?= $row['id'] ?>" 
                               class="delete-btn" 
                               onclick="return confirm('Удалить запись студента <?= htmlspecialchars($row['name']) ?>?')"
                               title="Удалить"></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="table-footer">
                Всего записей: <strong><?= count($students) ?></strong>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon"></div>
                <h3>В базе данных пока нет студентов</h3>
                <p>Добавьте первого студента через форму регистрации</p>
                <a href="form.html"> Добавить студента</a>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 10px; font-size: 14px; color: #666;">
            <p style="text-align: center;">
                🔗 Подключение к MySQL: <code>mysql -h 127.0.0.1 -P 3307 -u lab5_user -p lab5_db</code><br>
                 Adminer: <a href="http://localhost:8081" target="_blank">http://localhost:8081</a> (сервер: <strong>db</strong>)
            </p>
        </div>
    </div>
</body>
</html>