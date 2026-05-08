<?php

require_once 'db.php';

class Student {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->db->createMessagesTable();
    }
    
    // Сохранение данных студента из Kafka
    public function saveFromKafka($data) {
        $name = $data['name'] ?? 'Неизвестно';
        $message = $data['message'] ?? '';
        
        return $this->db->saveMessage($name, $message);
    }
    
    // Получение всех студентов/сообщений
    public function getAll() {
        return $this->db->getMessages();
    }
    
    // Статистика по студентам
    public function getStats() {
        $pdo = $this->db->getConnection();
        $sql = "SELECT 
                    COUNT(*) as total,
                    COUNT(DISTINCT name) as unique_names
                FROM messages";
        $stmt = $pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>