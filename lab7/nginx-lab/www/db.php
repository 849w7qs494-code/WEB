<?php

class Database {
    private static $instance = null;
    private $pdo;
    
    private function __construct() {
        // Для MySQL/MariaDB
        $host = 'mysql'; // или 'db', 'localhost'
        $dbname = 'lab7_db';
        $user = 'root';
        $pass = 'root';
        
        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $user,
                $pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Ошибка подключения: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->pdo;
    }
    
    public function createMessagesTable() {
        $sql = "CREATE TABLE IF NOT EXISTS messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            message TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }
    
    public function saveMessage($name, $message) {
        $sql = "INSERT INTO messages (name, message) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $message]);
    }
    
    public function getMessages($limit = 20) {
        $sql = "SELECT * FROM messages ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>