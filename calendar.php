<?php
session_start();

require_once 'connection.php';
$_SESSION['talone'] =
    [
        "month" => $_POST['month'],
        "specialization" => $_POST['specialization'],
        "date" => $_POST['date'],
        "smena" => $_POST['time'],
        "doctor_name",
    ];
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
        <?php
        if (true) {

        }
        ?>
        <div class="calendar"> <!--Для лозунга-->
            <form name='calendar' action="calendar2.php" method="post"> <!--Блок выбора-->
                <div class="title_and_number">
                    <p>Выберите врача</p>
                    <?php

                    $month = $_POST['month'];
                    $specialization = $_POST['specialization'];
                    $time = $_POST['time'];
                    $date = $_POST['date'];

                    $doctor_name = mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `doctor` WHERE `id_specialization` = '$specialization' AND `id_smena` = '$time'");
                    $doctor_name = mysqli_fetch_all($doctor_name);
                    $doctor_name_count = mysqli_query($connect, "SELECT COUNT(*) FROM `doctor` WHERE `id_specialization` = '$specialization' AND `id_smena` = '$time'");
                    $doctor_name_count = mysqli_fetch_all($doctor_name_count);



                    ?>
                    <div class="number">
                        <?php



                        for ($i = 0; $i < $doctor_name_count[0][0]; $i++) {

                        ?>
                        <div class="form_radio_btn">
                            <input id="radio<?= $i ?>" type="radio" name="doctor_name"
                                value="<?= $doctor_name[$i][1] ?>">
                            <label for="radio<?= $i ?>">
                                <?= $doctor_name[$i][1] . " " . substr($doctor_name[$i][0], 0, 2) . "." .
                                    substr($doctor_name[$i][2], 0, 2) . "." ?>
                            </label>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="buttons">
                    <div>
                    <a href="index.php"><button class="sybmit1">Предыдущий шаг</input></a>
                    </div>
                    <div>
                    <button type="submit" class="sybmit">Следующий шаг</input>
                    </div>
                </div>

        </div>

        </form>
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