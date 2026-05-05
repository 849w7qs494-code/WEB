<?php
// code/Database.php

class Database
{
    public static function saveStudent(string $name, string $email): bool
    {
        // В реальной реализации здесь будет подключение к MySQL и INSERT
        // Сейчас — заглушка, всегда возвращает true
        return true;
    }
}