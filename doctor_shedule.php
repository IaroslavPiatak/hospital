<?php
session_start();
require_once "connection.php";

$login = $_SESSION['user_autorization']['login'];
$password = $_SESSION['user_autorization']['password'];

$id_user = mysqli_query($connect, "SELECT `id_user` FROM user WHERE `login` = '$login' AND `password` = '$password'");
$id_user = mysqli_fetch_all($id_user);
$id_user = $id_user[0][0];
$doctor_name = mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM doctor WHERE `id_user` = '$id_user' ");
$doctor_name = mysqli_fetch_all($doctor_name);
$doctor_first_name = $doctor_name[0][0];
$doctor_last_name = $doctor_name[0][1];
$doctor_patronymic_name = $doctor_name[0][2];
$cabinet = mysqli_query($connect, "SELECT `cabinet` FROM `doctor` WHERE `id_user` = '$id_user'");
$cabinet = mysqli_fetch_all($cabinet);
$cabinet = $cabinet[0][0];
$cabinet = mysqli_query($connect, "SELECT `name_cabinet` FROM `cabinet` WHERE `id_cabinet` = '$cabinet'");
$cabinet = mysqli_fetch_all($cabinet);
$cabinet = $cabinet[0][0];
$specialization = (mysqli_fetch_all(mysqli_query($connect, "SELECT `name_specialization` FROM `specialization` 
JOIN `doctor` ON `doctor`.`id_specialization` = `specialization`.`id_specialization`
WHERE `doctor`.`id_user` = '$id_user'"))[0][0]);
$smena = (mysqli_fetch_all(mysqli_query($connect, "SELECT `name_smena` FROM `smena`
JOIN `doctor` ON `doctor`.`id_smena` = `smena`.`id_smena` 
WHERE `doctor`.`id_user` = '$id_user'"))[0][0]);
$day_of_week = $_POST['date'];
$day_of_week = date("N", $day_of_week);


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Личный кабинет доктора</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
        <link rel="stylesheet" href="css/lk_doctor.css" type="text/css">
    </head>
    <body>
        <!--Главный контейнер-->
        <div class="container">
            <!--Навигация-->
            <nav class="navbar">
                <a href="index.html">Главная</a>
                <a href="#">Приемы</a>
                <a href="#bol_list">Больничные листы</a>
                <a href="#">Записаться на прием</a>
                <a href="#">Выйти из личного кабинета</a>
            </nav>
            <div class="info_doctor">
                <div class="foto_doctor"></div>
                <form class="profile_doctor">
                <label for="last_name">Фамилия: </label>
                <input id="last_name" type="text" name="last_name" value="<?= $doctor_last_name ?>" readonly>
                <label for="first_name">Имя: </label>
                <input id="first_name" type="text" name="first_name" value="<?= $doctor_first_name ?>" readonly>
                <label for="patronymic_name">Отчество: </label>
                <input id="patronymic_name" type="text" name="patronymic_name" value="<?= $doctor_patronymic_name ?>" readonly>
                <label for="cabinet">Кабинет: </label>
                <input id="cabinet" type="text" name="specialization" value="<?= $cabinet ?>" readonly>
                <label for="">Специализация: </label>
                <input id="specialization" type="text" name="specialization" value="<?= $specialization ?>" readonly>
                <label for="">Смена: </label>
                <input id="smena" type="text" name="smena" value="<?= $smena ?>" readonly>
                <label for="">Логин: </label>
                <input id="login" type="text" name="login" value="<?= $login ?>" readonly>
                <label for="">Смена: </label>
                <input id="password" type="password" name="password" value="<?= $password ?>" readonly>
                </form>
            </div>
            <div class="priem">
                <h2>Расписание приемов</h2>
            <form class="calendar_priem" action="doctor_shedule" method="post">
                <input  type ="date" class="date" name="date">
                <input  type ="submit" class="date">
            </div>
            </form>
            </div>
            <div class="boll_list">
                <form class="priemm">
                    <!--Поле текста-->
                        <label>Справка:<span>№101</span>
                                Дата <span>07.01.2002</span>
                        </label>
                        <button class="btn4" type = "submit">Подробнее</button>
                        <label>Справка:<span>№101</span>
                                Дата <span>07.01.2002</span>
                        </label>
                        <button class="btn5" type = "submit">Подробнее</button>
                        <label>Справка:<span>№101</span>
                                Дата <span>07.01.2002</span>
                        </label>
                        <button class="btn6" type = "submit">Подробнее</button>
                        <label>Справка:<span>№101</span>
                                Дата <span>07.01.2002</span>
                        </label>
                        <button class="btn7" type = "submit">Подробнее</button>
                        <label>Справка:<span>№101</span>
                                Дата <span>07.01.2002</span>
                         </label>
                         <button class="btn8" type = "submit">Подробнее</button>
                        </form>
            </div>
            <div class="ekp">
                <form class="ekp_form">
                    <!--Поле текста-->
                        <label>Пациент:<span>Пятак Я.А.</span>
                        </label>
                        <button class="btn4" type = "submit">Подробнее</button>
                        <label>Пациент:<span>Пятак Я.А.</span>
                        </label>
                        <button class="btn5" type = "submit">Подробнее</button>
                        <label>Пациент:<span>Пятак Я.А.</span>
                        </label>
                        <button class="btn6" type = "submit">Подробнее</button>
                        <label>Пациент:<span>Пятак Я.А.</span>
                        </label>
                        <button class="btn7" type = "submit">Подробнее</button>
                        <label>Пациент:<span>Пятак Я.А.</span>
                         </label>
                         <button class="btn8" type = "submit">Подробнее</button>
                        </form>
            </div>
        </div>
    </body>
</html>