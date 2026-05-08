# Лабораторная работа №2 
Тема: Настройка Nginx + PHP-FPM. Основы HTML-форм и обработка на JavaScript

## 👩‍💻 Автор
ФИО: Алешкина София Никитична 

Группа: 2ПМ-ИП_3

---

## 📌 Описание задания
1. Настроить связку Nginx + PHP-FPM в Docker
2. Создать HTML-форму регистрации студента
3. Добавить JavaScript для обработки формы без перезагрузки страницы

Результат доступен по адресу:  
**Форма регистрации:** [http://localhost:8080/form.html](http://localhost:8080/form.html)  
**PHP информация:** [http://localhost:8080/index.php](http://localhost:8080/index.php)

---

## ⚙️ Как запустить проект

1. Клонировать репозиторий:
   ```bash
   git clone https://github.com/849w7qs494-code/WEB.git
   cd "WEB/lab 2"
2. Запустить контейнеры:
```bash
docker-compose up -d --build
```
3. Открыть в браузере:

```http://localhost:8080/index.php``` - PHP

```http://localhost:8080/form.html``` - Форма

📂 Содержимое проекта

```www/form.html``` - форма регистрации студента

```screenshots/``` — все скриншоты
