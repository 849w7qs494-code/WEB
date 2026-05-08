<?php
class Student {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->createTable();
    }

    private function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS students (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            age INT,
            faculty VARCHAR(100),
            study_form VARCHAR(50),
            agree_rules TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    public function add($name, $age, $faculty, $study_form, $agree_rules) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO students (name, age, faculty, study_form, agree_rules) 
             VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$name, $age, $faculty, $study_form, $agree_rules]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM students ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM students WHERE id = ?");
        return $stmt->execute([$id]);
    }
}