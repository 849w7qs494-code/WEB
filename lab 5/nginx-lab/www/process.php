<?php
require 'db.php';
require 'Student.php';

$student = new Student($pdo);

$name = htmlspecialchars($_POST['fullname'] ?? '');
$age = intval($_POST['age'] ?? 0);
$faculty = htmlspecialchars($_POST['faculty'] ?? '');
$study_form = htmlspecialchars($_POST['education'] ?? '');
$agree = isset($_POST['agree']) ? 1 : 0;

$errors = [];

if (empty($name)) $errors[] = "Введите имя";
if ($age < 16 || $age > 35) $errors[] = "Возраст должен быть от 16 до 35";
if (empty($faculty)) $errors[] = "Выберите факультет";
if (empty($study_form)) $errors[] = "Выберите форму обучения";
if (!$agree) $errors[] = "Необходимо согласие с правилами";

if (!empty($errors)) {
    session_start();
    $_SESSION['errors'] = $errors;
    header("Location: form.html");
    exit();
}

$student->add($name, $age, $faculty, $study_form, $agree);

header("Location: index.php");
exit();