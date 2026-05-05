<?php
// code/index.php
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация студента</title>
</head>
<body>
    <h2>Форма регистрации студента</h2>
    <form method="POST" action="register.php">
        <label>Имя:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <button type="submit">Зарегистрировать</button>
    </form>
</body>
</html>