<?php
session_start();
if ($_SESSION['user_autorization'] AND $_SESSION['user_autorization']['login'] != 'admin' )
    header('Location: lk_patient.php');

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/reg.css" type="text/css" />
</head>

<body>
    <!--основная формочка регистрации-->
    <form action='uppload/signup.php' method="post">
        <div class="forms">
            <p class="p1">Регистрация</p>
            <input type="text" class="log" name="last_name" maxlength="25" placeholder="Введите вашу Фамилию" required>
            <!--форма фамилии-->
            <input type="text" class="gol" name="first_name" maxlength="25" placeholder="Введите ваше Имя" required>
            <!--форма имени-->
            <input type="text" class="ogl" name="patronymic_name" maxlength="25" placeholder="Введите ваше Отчество"
                required>
            <!--форма отчества-->
            <input type="date" class="olg" name="date_of_birthday" placeholder="Введите дату рождения" required>
            <!--форма дата рождения-->
            <input type="number" class="lgo" name="mip_number" maxlength="16" placeholder="Введите номер СМП" required  min="1000000000000000" max="9999999999999999">
            <!--форма СМП-->
            <!--кнопка перехода-->
            <button type="submit">Следующий шаг</button>
        </div>
      
    </form>

    <!---->

</body>

</html>