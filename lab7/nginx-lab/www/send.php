<?php
// Подключаем автозагрузку Composer (если есть)
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// Простой класс QueueManager для теста (если нет Composer)
class QueueManager {
    private $topic = 'lab7_topic';
    
    public function publish($data) {
        // Временно просто сохраняем в файл
        $logFile = 'processed_kafka.log';
        $message = json_encode($data) . PHP_EOL;
        file_put_contents($logFile, $message, FILE_APPEND);
        return true;
    }
}

// Получаем данные из формы
$name = $_POST['name'] ?? 'Аноним';
$message = $_POST['message'] ?? '';

if (!empty($message)) {
    $q = new QueueManager();
    $data = [
        'name' => $name,
        'message' => $message,
        'time' => date('Y-m-d H:i:s'),
        'id' => uniqid()
    ];
    
    if ($q->publish($data)) {
        echo "✅ Сообщение успешно отправлено!<br>";
        echo "<a href='/'>Вернуться назад</a>";
    } else {
        echo "❌ Ошибка отправки сообщения<br>";
        echo "<a href='/'>Попробовать снова</a>";
    }
} else {
    echo "❌ Сообщение не может быть пустым<br>";
    echo "<a href='/'>Вернуться назад</a>";
}
?>