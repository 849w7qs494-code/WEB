<?php
// code/register.php
require_once 'Student.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    $success = Student::register($name, $email);

    if ($success) {
        echo "<h3>Студент успешно зарегистрирован!</h3>";
    } else {
        echo "<h3 style='color:red;'>Ошибка: проверьте данные.</h3>";
    }
}
?>
<a href="index.php">← Назад</a>