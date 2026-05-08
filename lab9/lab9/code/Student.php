<?php
// code/Student.php

class Student
{
    /**
     * Регистрирует студента после валидации данных
     * @param string $name
     * @param string $email
     * @return bool
     */
    public static function register(string $name, string $email): bool
    {
        // Валидация имени
        if (empty(trim($name))) {
            return false;
        }

        // Валидация email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        
        return true;
    }
}