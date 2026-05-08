document.getElementById('studentForm').addEventListener('submit', function(e) {
    // Получаем значения полей
    const fullname = this.fullname.value;
    const age = this.age.value;
    const country = this.country.options[this.country.selectedIndex]?.text;
    const faculty = this.faculty.options[this.faculty.selectedIndex]?.text;
    const education = document.querySelector('input[name="education"]:checked')?.value;
    const email = this.email.value;
    
    // Показываем alert с данными
    alert(` Проверьте данные:\n\nФИО: ${fullname}\nВозраст: ${age}\nСтрана: ${country}\nФакультет: ${faculty}\nФорма: ${education}\nEmail: ${email}\n\nДанные будут отправлены на сервер.`);
    
    // Форма отправится на process.php (action="process.php" method="POST")
});