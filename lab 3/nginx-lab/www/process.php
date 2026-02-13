<?php
// СТАРТУЕМ СЕССИЮ
session_start();

// ПОЛУЧАЕМ ДАННЫЕ ИЗ ФОРМЫ
$fullname = $_POST['fullname'] ?? '';
$age = $_POST['age'] ?? '';
$faculty = $_POST['faculty'] ?? '';
$education = $_POST['education'] ?? '';
$email = $_POST['email'] ?? '';

// ОЧИЩАЕМ ОТ ВРЕДОНОСНОГО КОДА
$fullname = htmlspecialchars($fullname);
$age = htmlspecialchars($age);
$faculty = htmlspecialchars($faculty);
$education = htmlspecialchars($education);
$email = htmlspecialchars($email);

// ========== ПРОВЕРКА ОШИБОК ==========
$errors = [];

if (empty($fullname)) {
    $errors[] = "ФИО не может быть пустым";
}

if (empty($age) || $age < 16 || $age > 35) {
    $errors[] = "Возраст должен быть от 16 до 35 лет";
}

if (empty($faculty)) {
    $errors[] = "Выберите факультет";
}

if (empty($education)) {
    $errors[] = "Выберите форму обучения";
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Введите корректный Email";
}

// ЕСЛИ ЕСТЬ ОШИБКИ
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;      // сохраняем ошибки в сессию
    header("Location: index.php");      // редирект на главную
    exit();
}

// ========== ЕСЛИ ОШИБОК НЕТ ==========
// 1. СОХРАНЯЕМ В СЕССИЮ
$_SESSION['student'] = [
    'fullname' => $fullname,
    'age' => $age,
    'faculty' => $faculty,
    'education' => $education,
    'email' => $email
];

// 2. СОХРАНЯЕМ В ФАЙЛ
$line = $fullname . ";" . $age . ";" . $faculty . ";" . $education . ";" . $email . "\n";
file_put_contents("data.txt", $line, FILE_APPEND);

// 3. СООБЩЕНИЕ ОБ УСПЕХЕ
$_SESSION['success'] = "Данные успешно сохранены!";

// 4. ПЕРЕНАПРАВЛЯЕМ НА ГЛАВНУЮ
header("Location: index.php");
exit();