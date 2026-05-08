<?php
// tests/StudentTest.php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../code/Student.php';

class StudentTest extends TestCase
{
    public function testRegisterValidStudent(): void
    {
        $result = Student::register('Иван Иванов', 'ivan@example.com');
        $this->assertTrue($result, 'Валидный студент должен быть зарегистрирован');
    }

    public function testRegisterInvalidEmail(): void
    {
        $result = Student::register('Иван Иванов', 'not-an-email');
        $this->assertFalse($result, 'Невалидный email должен отклоняться');
    }

    public function testRegisterEmptyName(): void
    {
        $result = Student::register('', 'ivan@example.com');
        $this->assertFalse($result, 'Пустое имя должно отклоняться');
    }

    public function testRegisterWhitespaceOnlyName(): void
    {
        $result = Student::register('   ', 'ivan@example.com');
        $this->assertFalse($result, 'Имя из пробелов должно отклоняться');
    }
}