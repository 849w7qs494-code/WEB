<!DOCTYPE html>
<html>
<head>
    <title>ЛР7 - Kafka</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .form { background: #f0f0f0; padding: 20px; border-radius: 5px; }
        input, textarea, button { margin: 10px 0; padding: 8px; width: 100%; }
        button { background: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>📨 Отправка сообщений в Kafka</h1>
    
    <div class="form">
        <form action="send.php" method="POST">
            <input type="text" name="name" placeholder="Ваше имя" required>
            <textarea name="message" rows="3" placeholder="Ваше сообщение" required></textarea>
            <button type="submit">Отправить</button>
        </form>
    </div>
    
    <h2>Последние сообщения:</h2>
    <?php
    $logFile = 'processed_kafka.log';
    if (file_exists($logFile)) {
        $lines = file($logFile);
        $lines = array_reverse($lines);
        $count = 0;
        foreach ($lines as $line) {
            if ($count++ >= 10) break;
            $data = json_decode(trim($line), true);
            if ($data) {
                echo "<div style='border-left: 3px solid #4CAF50; margin: 10px 0; padding: 10px; background: #f9f9f9;'>";
                echo "<strong>{$data['name']}</strong> <small>({$data['time']})</small><br>";
                echo "{$data['message']}";
                echo "</div>";
            }
        }
    } else {
        echo "<p>Нет сообщений</p>";
    }
    ?>
</body>
</html>