<?php
session_start();

require_once 'ApiClient.php';
require_once 'UserInfo.php';

// Получаем данные
$fullname = $_POST['fullname'] ?? '';
$age = $_POST['age'] ?? '';
$countryId = $_POST['country'] ?? '';  // получаем ID страны
$faculty = $_POST['faculty'] ?? '';
$education = $_POST['education'] ?? '';
$email = $_POST['email'] ?? '';

// Очищаем
$fullname = htmlspecialchars($fullname);
$age = htmlspecialchars($age);
$countryId = htmlspecialchars($countryId);
$faculty = htmlspecialchars($faculty);
$education = htmlspecialchars($education);
$email = htmlspecialchars($email);

// Валидация
$errors = [];

if (empty($fullname)) $errors[] = "Введите ФИО";
if (empty($age) || $age < 16 || $age > 35) $errors[] = "Возраст должен быть от 16 до 35 лет";
if (empty($countryId)) $errors[] = "Выберите страну";
if (empty($faculty)) $errors[] = "Выберите факультет";
if (empty($education)) $errors[] = "Выберите форму обучения";
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Введите корректный email";

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

// Получаем название страны по ID
$api = new ApiClient();
$areas = $api->getAreas();
$countryName = $countryId;

// Ищем название страны
foreach ($areas as $country) {
    if ($country['id'] == $countryId) {
        $countryName = $country['name'];
        break;
    }
}

// Сохраняем в сессию
$_SESSION['student'] = [
    'fullname' => $fullname,
    'age' => $age,
    'country' => $countryName,
    'faculty' => $faculty,
    'education' => $education,
    'email' => $email,
    'timestamp' => date('Y-m-d H:i:s')
];

// Сохраняем данные API
$_SESSION['api_data'] = [
    'time' => date('Y-m-d H:i:s'),
    'data' => $areas
];

// Информация о пользователе
$_SESSION['user_info'] = UserInfo::getInfo();

// Куки
setcookie("last_submission", date('Y-m-d H:i:s'), time() + 3600, "/");

// Сохраняем в файл
$line = "$fullname;$age;$countryName;$faculty;$education;$email;" . date('Y-m-d H:i:s') . "\n";
file_put_contents("data.txt", $line, FILE_APPEND);

$_SESSION['success'] = "Данные сохранены!";
header("Location: index.php");
exit();