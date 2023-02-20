<?php
session_start(); // запускаем сессии, подключаем файл для коннекта с БД
require_once 'connection.php';

?>

<html>

<head>
    <title>Личный кабинет пациента</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/change_status.css" type="text/css"> <!--для обнуления-->
</head>

<body>
    <div class="container"> <!--Главный контейнер-->
        <nav class="navbar"> <!--Навигация-->
            <a class="navbar_a" href="index.php">Главная</a>
            <a class="navbar_exit" href="uppload/logout.php">Выйти из личного кабинета</a>
        </nav>
        <div class="header"> <!--Шапка-->
            <?php // запуск скрипта по извлечению информации
            

            $login = $_SESSION['user_autorization']['login']; // вытаскиваем логин и пароль, которые получаем при авторизации 
            $password = $_SESSION['user_autorization']['password'];
            $login_and_password = mysqli_query($connect, "SELECT * FROM `user` WHERE `login` = '$login' AND `password` = '$password'"); // из таблицы user, вытаскиваем id_user , пароль. логин. 
            $login_and_password = mysqli_fetch_all($login_and_password); // все полученное формируем в массив
            foreach ($login_and_password as $login_and_password) { // перебираем массив из полученных элементов 
                $id_user = $login_and_password[0]; // вытаскиваем id_user
                $login_patient = $login_and_password[1]; // логин пациента
                $password_patient = $login_and_password[2]; // пароль пациента
            
            }

            $check_user_id = mysqli_query($connect, " SELECT `name_status` FROM `status` JOIN `patient` ON `status`.`id_status` = `patient`.`status`;"); // соединяем 2 таблицы и вытаскиваем статус
            $check_user_id = mysqli_fetch_all($check_user_id); // помещаем статус в массив
            foreach ($check_user_id as $check_user_id) { // перебираем массив из полученных элементов 
                $status_patient = $check_user_id[0]; // вытаскиваем статус
            
            }
            ?>



            <form class="speciali" action="uppload/change_status.php" method="post"> <!--форма, которую будет менять админ-->
                <div class="block">
                    <label class="speciali_label" for="login">Ваш логин: </label>
                    <input maxlength="15" class="speciali_input_change" id="login" type="text" name="login" value="<?= $login_patient ?>">
                </div>
                <!--через value задаем изначальное значение-->
                <div class="block">
                    <label class="speciali_label" for="login">Ваш пароль: </label>
                    <input maxlength="15" class="speciali_input_change" id=" login" type="text" name="password"
                        value="<?= $password_patient ?>">
                </div>
                <div class="block">
                <label class="speciali_label for=" login">Ваш cтатус: </label>
                <input class="speciali_input id=" login" type="text" name="status" value="<?= $status_patient ?>"
                    readonly>
                </div>
                <button type="submit" class="speciali_submit">Принять изменения</button>
                <input type="hidden" name="id_user" value="<?= $id_user ?>">
                
            </form>



</body>