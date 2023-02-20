<?php
session_start();
require_once 'connection.php';
$day = $_SESSION['talone']['date'];

$login = $_SESSION['user_autorization']['login'];
$password = $_SESSION['user_autorization']['password'];
$user_id = mysqli_query($connect, "SELECT `id_user` FROM user WHERE `login` = '$login' AND `password` = '$password'");
$user_id = mysqli_fetch_all($user_id);
$user_id = $user_id[0][0];
$id_patient = mysqli_query($connect, "SELECT `id_patient` FROM patient WHERE `user_id` = '$user_id'");
$id_patient = mysqli_fetch_all($id_patient);
$id_patient = $id_patient[0][0];
$doctor_name = $_SESSION['talone']['doctor_name'];
$doctor_name = mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name`  FROM `doctor` WHERE `doctor`.`last_name` = '$doctor_name'");
$doctor_name = mysqli_fetch_all($doctor_name);
$doctor_first_name = $doctor_name[0][0];
$doctor_last_name = $doctor_name[0][1];
$doctor_patronymic_name = $doctor_name[0][2];
$id_doctor = mysqli_query($connect, "SELECT `id_doctor` FROM doctor WHERE `first_name` = '$doctor_first_name' AND `last_name` = '$doctor_last_name' AND `patronymic_name` = '$doctor_patronymic_name'");
$id_doctor = mysqli_fetch_all($id_doctor);
$id_doctor = $id_doctor[0][0];
$id_specialization = $_SESSION['talone']['specialization'];
$id_cabinet = $_SESSION['talone']['cabinete'];
$id_cabinet = mysqli_query($connect, "SELECT `cabinet` FROM `doctor` WHERE `doctor`.`last_name` = '$doctor_last_name'");
$id_cabinet = mysqli_fetch_all($id_cabinet);
$id_cabinet = $id_cabinet[0][0];



$specialization = $_SESSION['talone']['specialization'];
$specialization = mysqli_query($connect, "SELECT `name_specialization` FROM `specialization` WHERE `id_specialization` = '$specialization'");
$specialization = mysqli_fetch_all($specialization);
$specialization = $specialization[0][0];

$cabinet = mysqli_query($connect, "SELECT `cabinet` FROM `doctor` WHERE `doctor`.`last_name` = '$doctor_last_name'");
$cabinet = mysqli_fetch_all($cabinet);
$cabinet = $cabinet[0][0];
$cabinet = mysqli_query($connect, "SELECT `name_cabinet` FROM `cabinet` WHERE `id_cabinet` = '$cabinet'");
$cabinet = mysqli_fetch_all($cabinet);
$cabinet = $cabinet[0][0];



$month_and_year = $_SESSION['talone']['month'];
list($temp1, $temp2) = explode(' ', $month_and_year);
$month_number = $temp2;
$year = $temp1;

switch ($month_number) {
    case 1:
        $month = 'Января';
        break;
    case 2:
        $month = 'Февраля';
        break;
    case 3:
        $month = 'Марта';
        break;
    case 4:
        $month = 'Аплеря';
        break;
    case 5:
        $month = 'Мая';
        break;
    case 6:
        $month = 'Июня';
        break;
    case 7:
        $month = 'Июля';
        break;
    case 8:
        $month = 'Августа';
        break;
    case 9:
        $month = 'Сентября';
        break;
    case 10:
        $month = 'Октября';
        break;
    case 11:
        $month = 'Ноября';
        break;
    case 12:
        $month = 'Декабря';
        break;
}
$time = $_POST['date'];


$check_day = ($year . '-' . $temp2 . '-' . $day);


$check_talone = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `talone` WHERE `date` = '$check_day' AND `id_patient` = '$id_patient'"))[0][0];

if ($check_talone > 0) {
    $_SESSION['warrning'] =
        [
            'text' => 'Вы уже записаны на этот день !',
            'link' => 'index.php',
            'name_button' => 'ОК'
        ];

    $_SESSION['user_autorization'] = array();
    unset($_SESSION['user_autorization']);
    header('Location: ../warrning.php');
} else {
?>
<?php

    // год - месяц - число
    $date = $year . '.' . $month_number . '.' . $day;


    mysqli_query($connect, "INSERT INTO `talone` (`id_patient`, `id_doctor_name`, `id_spetialization`, `id_cabinet`, `date`,
`time`) VALUES ( '$id_patient', '$id_doctor', '$id_specialization', '$id_cabinet', '$date', '$time')");
?>


<!DOCTYPE html>
<html>

<head>
    <title>Главная</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/calendar.css" type="text/css"> <!--для обнуления-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container"> <!--Главный контейнер-->
        <nav class="navbar"> <!--Навигация-->
            <a href="index.php #calendar">Запись на прием</a>
            <a href="#" download="document/Руководство_пользователя.docx">Руководство пользователя</a>
            <a href="#footer">Контакты</a>
            <a href="autorization.php">Личный кабинет</a>
        </nav>
        <div class="header"> <!--Шапка сайта-->
            <div class="text"> <!--Для лозунга-->
                <h1>Запишитесь на прием!</h1>
                <h2>Будьте здоровы!</h2>
            </div>
        </div>

        <div class="calendar">
            <!--талон-->
            <div class="talon">
                <?php
    $_SESSION['talone'] = array();

    echo '
            <p>Ваш талончик на прием</p>
            <label>Врач: ' . $doctor_last_name . ' ' . substr($doctor_first_name, 0, 2) . '.' . substr($doctor_patronymic_name, 0, 2) . '.' . '</label>
            <label>' . $specialization . '</label>
            <label>Кабинет: ' . $cabinet . '</label>
            <label>Дата приема:   ' . $day . ' ' . $month . ' ' . $year . '</label>
            <label>Время приема:   ' . $time . '</label>
            </div>
            
                <a href = "index.php"><button class="btn1">Спасибо!</button></a>';

                ?>


            </div>

            <!---->
        </div>
        <!---->
        <!--Подвал-->
        <footer id='footer'>
            <div class="contac">Сайт сделан ПАО "ШПКЛ"</p>
                <div class="contact">
                    <p>Контакты для связи:<br> Email: slavik.ipp@gmail.com <br> Telegram: Iaroslav_AP <br> 2022</p>
                </div>
        </footer>
        <!---->
</body>
<?php



}