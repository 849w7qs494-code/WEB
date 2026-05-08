<?php
require __DIR__ . '/vendor/autoload.php';

// Подключаем классы вручную
require_once 'RedisExample.php';
require_once 'ElasticExample.php';
require_once 'ClickhouseExample.php';
require_once 'Helpers/ClientFactory.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР6 - Не реляционные БД</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
            border-left: 4px solid;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card.redis { border-left-color: #dc3545; }
        .card.elastic { border-left-color: #f0ad4e; }
        .card.clickhouse { border-left-color: #5cb85c; }
        .card h3 {
            margin-bottom: 20px;
            color: #333;
            font-size: 20px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }
        .card h4 {
            margin: 15px 0 10px;
            color: #555;
        }
        .card ul {
            list-style: none;
            margin: 15px 0;
        }
        .card li {
            padding: 8px 12px;
            margin: 5px 0;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 10px;
            overflow-x: auto;
            font-size: 13px;
            margin: 15px 0;
            max-height: 300px;
        }
        .success { 
            color: #5cb85c; 
            font-weight: 600;
            background: #e8f5e8;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .error { 
            color: #dc3545; 
            font-weight: 600;
            background: #ffebee;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .info-box {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
        }
        .info-box h3 {
            color: #333;
            margin-bottom: 15px;
        }
        .info-box ul {
            list-style: none;
        }
        .info-box li {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .info-box li:last-child {
            border-bottom: none;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        .badge.redis { background: #dc3545; color: white; }
        .badge.elastic { background: #f0ad4e; color: white; }
        .badge.clickhouse { background: #5cb85c; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 Лабораторная работа №6</h1>
        <div class="subtitle">
            Тема 1: Пользователи (Redis) 
            <span class="badge redis">Redis</span> + 
            <span class="badge elastic">Elasticsearch</span> + 
            <span class="badge clickhouse">ClickHouse</span>
        </div>
        
        <div class="nav">
            <a href="#redis"> Redis</a>
            <a href="#elastic"> Elasticsearch</a>
            <a href="#clickhouse"> ClickHouse</a>
        </div>
        
        <div class="grid">
            <!-- ========== REDIS (Тема 1: Пользователи) ========== -->
            <div class="card redis" id="redis">
                <h3> Redis (Тема 1: Пользователи)</h3>
                <?php
                try {
                    $redis = new RedisExample();
                    
                    $deleted = $redis->deleteAllUsers();
                    if ($deleted > 0) {
                        echo "<p class='success'>✅ Очищено $deleted старых записей</p>";
                    }
                    
                    $users = [
                        1 => ['name' => 'Иван Петров', 'email' => 'ivan@mail.ru', 'age' => 25, 'city' => 'Москва'],
                        2 => ['name' => 'Мария Иванова', 'email' => 'maria@mail.ru', 'age' => 30, 'city' => 'СПб'],
                        3 => ['name' => 'Петр Сидоров', 'email' => 'petr@mail.ru', 'age' => 22, 'city' => 'Москва'],
                        4 => ['name' => 'Анна Козлова', 'email' => 'anna@mail.ru', 'age' => 28, 'city' => 'Казань'],
                    ];
                    
                    foreach ($users as $id => $data) {
                        $redis->createUser($id, $data);
                    }
                    
                    echo "<p class='success'>✅ Создано " . count($users) . " пользователей</p>";
                    
                    $allUsers = $redis->getAllUsers();
                    
                    if (!empty($allUsers)) {
                        echo "<h4>📋 Список пользователей в Redis:</h4>";
                        echo "<ul>";
                        foreach ($allUsers as $id => $data) {
                            $city = $data['city'] ?? 'не указан';
                            echo "<li>";
                            echo "<strong>#$id</strong> {$data['name']}, ";
                            echo "{$data['age']} лет, ";
                            echo "<span style='color: #667eea;'>{$city}</span>";
                            echo " <small>({$data['email']})</small>";
                            echo "</li>";
                        }
                        echo "</ul>";
                        
                        $moscow = array_filter($allUsers, fn($u) => ($u['city'] ?? '') === 'Москва');
                        echo "<p><strong>Статистика:</strong> всего пользователей: " . count($allUsers) . ", из Москвы: " . count($moscow) . "</p>";
                    } else {
                        echo "<p>Нет пользователей</p>";
                    }
                    
                } catch (Exception $e) {
                    echo "<p class='error'>❌ Ошибка Redis: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
            
            <!-- ========== ELASTICSEARCH ========== -->
            <div class="card elastic" id="elastic">
                <h3> Elasticsearch</h3>
                <?php
                try {
                    $elastic = new ElasticExample();
                    
                    $docs = [
                        1 => ['name' => 'Иван Петров', 'city' => 'Москва', 'age' => 25, 'interests' => ['php', 'docker']],
                        2 => ['name' => 'Мария Иванова', 'city' => 'СПб', 'age' => 30, 'interests' => ['python', 'data']],
                        3 => ['name' => 'Петр Сидоров', 'city' => 'Москва', 'age' => 22, 'interests' => ['java', 'redis']],
                        4 => ['name' => 'Анна Козлова', 'city' => 'Казань', 'age' => 28, 'interests' => ['javascript', 'react']],
                    ];
                    
                    foreach ($docs as $id => $data) {
                        $result = $elastic->indexDocument('users', $id, $data);
                    }
                    
                    echo "<p class='success'>✅ Проиндексировано " . count($docs) . " документов</p>";
                    
                    $searchResult = $elastic->search('users', ['city' => 'Москва']);
                    
                    if (isset($searchResult['hits']['hits'])) {
                        $found = $searchResult['hits']['hits'];
                        echo "<h4>🔎 Поиск пользователей из Москвы:</h4>";
                        echo "<ul>";
                        foreach ($found as $hit) {
                            $source = $hit['_source'];
                            echo "<li><strong>{$source['name']}</strong>, {$source['age']} лет, интересы: " . implode(', ', $source['interests']) . "</li>";
                        }
                        echo "</ul>";
                        echo "<p>Найдено: " . count($found) . " чел.</p>";
                    }
                    
                    echo "<details>";
                    echo "<summary>📊 Показать полный ответ Elasticsearch</summary>";
                    echo "<pre>" . json_encode($searchResult, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
                    echo "</details>";
                    
                } catch (Exception $e) {
                    echo "<p class='error'>❌ Ошибка Elasticsearch: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
            
            <!-- ========== CLICKHOUSE ========== -->
            <div class="card clickhouse" id="clickhouse">
                <h3> ClickHouse</h3>
                <?php
                try {
                    $click = new ClickhouseExample();
                    
                    $click->query("CREATE TABLE IF NOT EXISTS user_events (
                        user_id UInt32,
                        event_date Date,
                        event_name String,
                        event_value UInt32,
                        event_city String
                    ) ENGINE = MergeTree()
                    ORDER BY (event_date, user_id)");
                    
                    echo "<p class='success'>✅ Таблица user_events создана</p>";
                    
                    $today = date('Y-m-d');
                    $yesterday = date('Y-m-d', strtotime('-1 day'));
                    $weekAgo = date('Y-m-d', strtotime('-7 days'));
                    
                    $events = [
                        ['user_id' => 1, 'event_date' => $today, 'event_name' => 'login', 'event_value' => 1, 'event_city' => 'Москва'],
                        ['user_id' => 1, 'event_date' => $today, 'event_name' => 'purchase', 'event_value' => 2500, 'event_city' => 'Москва'],
                        ['user_id' => 1, 'event_date' => $yesterday, 'event_name' => 'login', 'event_value' => 1, 'event_city' => 'Москва'],
                        ['user_id' => 2, 'event_date' => $today, 'event_name' => 'login', 'event_value' => 1, 'event_city' => 'СПб'],
                        ['user_id' => 2, 'event_date' => $today, 'event_name' => 'view', 'event_value' => 5, 'event_city' => 'СПб'],
                        ['user_id' => 2, 'event_date' => $yesterday, 'event_name' => 'login', 'event_value' => 1, 'event_city' => 'СПб'],
                        ['user_id' => 3, 'event_date' => $today, 'event_name' => 'login', 'event_value' => 1, 'event_city' => 'Москва'],
                        ['user_id' => 3, 'event_date' => $weekAgo, 'event_name' => 'register', 'event_value' => 1, 'event_city' => 'Москва'],
                        ['user_id' => 4, 'event_date' => $today, 'event_name' => 'login', 'event_value' => 1, 'event_city' => 'Казань'],
                        ['user_id' => 4, 'event_date' => $today, 'event_name' => 'purchase', 'event_value' => 3500, 'event_city' => 'Казань'],
                    ];
                    
                    $click->insert('user_events', $events);
                    echo "<p class='success'>✅ Вставлено " . count($events) . " событий</p>";
                    
                    $result1 = $click->query("
                        SELECT 
                            user_id,
                            count() as total_events,
                            sum(event_value) as total_value,
                            uniqExact(event_name) as unique_actions
                        FROM user_events 
                        WHERE event_date >= today() - 30
                        GROUP BY user_id
                        ORDER BY total_value DESC
                    ");
                    
                    echo "<h4>📊 Аналитика по пользователям:</h4>";
                    echo "<pre>" . $result1 . "</pre>";
                    
                    $result2 = $click->query("
                        SELECT 
                            event_city,
                            count() as events,
                            uniqExact(user_id) as users
                        FROM user_events 
                        GROUP BY event_city
                        ORDER BY events DESC
                    ");
                    
                    echo "<h4>📍 Статистика по городам:</h4>";
                    echo "<pre>" . $result2 . "</pre>";
                    
                } catch (Exception $e) {
                    echo "<p class='error'>❌ Ошибка ClickHouse: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
        </div>
        
        <!-- Информация о сервисах -->
        <div class="info-box">
            <h3>📊 Информация о сервисах</h3>
            <ul>
                <li><strong> Redis:</strong> порт 6379 (внутренний) / localhost:6379 (внешний)</li>
                <li><strong> Elasticsearch:</strong> http://localhost:9200</li>
                <li><strong> ClickHouse HTTP:</strong> http://localhost:8123</li>
                <li><strong> ClickHouse TCP:</strong> порт 9000</li>
                <li><strong> Docker контейнеры:</strong> lab6_php, lab6_redis, lab6_elastic, lab6_clickhouse</li>
            </ul>
        </div>
        
        <!-- Время загрузки -->
        <div style="text-align: center; margin-top: 20px; color: #888; font-size: 12px;">
            Страница сгенерирована: <?= date('Y-m-d H:i:s') ?>
        </div>
    </div>
</body>
</html>