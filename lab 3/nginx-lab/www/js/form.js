const form = document.getElementById('studentForm');

form.addEventListener('submit', function(e) {
    // Получаем данные
    const fullname = this.fullname.value;
    const age = this.age.value;
    const faculty = this.faculty.value;
    const education = document.querySelector('input[name="education"]:checked')?.value;
    const email = this.email.value;
    
    // Показываем alert с данными
    alert(` Подтверждение отправки:\n\nФИО: ${fullname}\nВозраст: ${age}\nФакультет: ${faculty}\nФорма: ${education}\nEmail: ${email}\n\nДанные будут отправлены на сервер.`);
    
    // Форма отправляется на process.php (action="process.php" method="POST")
});