<?php
session_start();
require_once 'connection.php';
$action = $_POST['action'];


if ($action == 'add_analyz') {
?>
<?php


    $id_patient = $_POST['id_patient'];
    $doctor_login = $_SESSION['user_autorization']['login'];
    $doctor_password = $_SESSION['user_autorization']['password'];
    $id_doctor = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_user` FROM `user`
    WHERE `login` = '$doctor_login' AND `password` = '$doctor_password'"))[0][0];
    $id_doctor = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_doctor` FROM `doctor`
    WHERE `id_user` = '$id_doctor'"))[0][0];
    $date = $_POST['date'];
    $patient_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `patient`
    WHERE `id_patient` = '$id_patient'"));

    $patient_first_name = $patient_name[0][0];
    $patient_last_name = $patient_name[0][1];
    $patient_patronymic_name = $patient_name[0][2];

    $doctor_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `doctor`
    WHERE `id_doctor` = '$id_doctor'"));

    $doctor_first_name = $doctor_name[0][0];
    $doctor_last_name = $doctor_name[0][1];
    $doctor_patronymic_name = $doctor_name[0][2];
    ?>
<?php

?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/add_appointment.css" type="text/css"><!--для обнуления-->

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">

            <a class="navbar_exit" href="lk_doctor.php">Вернуться в личный кабинет</a>

        </nav>
        <div class="content">


            <span class="doctor_title">Добавить запись анализа в ЭКП пациента: <span
                    style="color: #EC5863; margin-left: 20px;">
                    <?= $patient_last_name . " " . substr($patient_first_name, 0, 2) . "." .
        substr($patient_patronymic_name, 0, 2) . "." ?>
                </span></span>
            <form class="doctor_form" action="uppload/add_appointment.php" method="post">
                <input hidden name="id_patient" value="<?= $id_patient ?>">
                <input hidden name="date" value="<?= $date ?>">
                <input hidden name="action" value="analyz">

                <input required class="speciali_input1" type="text" name="name_analyz"
                    placeholder="Введите название анализа" maxlength="70">

                <textarea required class="speciali_input" name="result_analyz" placeholder="Введите результат анализа"
                    maxlength="255"></textarea>
                <div class="mother_box">
                    <div class="box">
                        <label class="speciali_label_doctor" for="doctor">Доктор: </label>
                        <input class="speciali_input_doctor" id=" login" value="<?= $doctor_last_name . " " . substr($doctor_first_name, 0, 2)
        . "." . substr($doctor_patronymic_name, 0, 2) . "." ?>" readonly>
                    </div>

                    <div class="box">
                        <label class="speciali_label_doctor" for="login">Дата: </label>
                        <input class="speciali_input_doctor" id=" login" value="<?= $date ?>" name="date" readonly>

                    </div>
                </div>



                <button class="doctor_submit" type="submit">Добавить запись</button>

            </form>



        </div>





    </div>
    </div>
</body>

</html>


<?php

} else if ($action == 'add_survey') {
    ?>
<?php


    $id_patient = $_POST['id_patient'];
    $doctor_login = $_SESSION['user_autorization']['login'];
    $doctor_password = $_SESSION['user_autorization']['password'];
    $id_doctor = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_user` FROM `user`
    WHERE `login` = '$doctor_login' AND `password` = '$doctor_password'"))[0][0];
    $id_doctor = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_doctor` FROM `doctor`
    WHERE `id_user` = '$id_doctor'"))[0][0];
    $date = $_POST['date'];
    $patient_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `patient`
    WHERE `id_patient` = '$id_patient'"));

    $patient_first_name = $patient_name[0][0];
    $patient_last_name = $patient_name[0][1];
    $patient_patronymic_name = $patient_name[0][2];

    $doctor_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `doctor`
    WHERE `id_doctor` = '$id_doctor'"));

    $doctor_first_name = $doctor_name[0][0];
    $doctor_last_name = $doctor_name[0][1];
    $doctor_patronymic_name = $doctor_name[0][2];
    ?>
<?php

?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/add_appointment.css" type="text/css"><!--для обнуления-->

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">

            <a class="navbar_exit" href="lk_doctor.php">Вернуться в личный кабинет</a>

        </nav>
        <div class="content">


            <span class="doctor_title">Добавить запись обследования в ЭКП пациента: <span
                    style="color: #EC5863; margin-left: 20px;">
                    <?= $patient_last_name . " " . substr($patient_first_name, 0, 2) . "." .
        substr($patient_patronymic_name, 0, 2) . "." ?>
                </span></span>
            <form class="doctor_form" action="uppload/add_appointment.php" method="post">
                <input hidden name="id_patient" value="<?= $id_patient ?>">
                <input hidden name="date" value="<?= $date ?>">
                <input hidden name="action" value="survey">

                <input required class="speciali_input1" type="text" name="name_survey"
                    placeholder="Введите название обследования" maxlength="70">

                <textarea required class="speciali_input" name="result_survey"
                    placeholder="Введите результат обследования" maxlength="255"></textarea>
                <div class="mother_box">
                    <div class="box">
                        <label class="speciali_label_doctor" for="doctor">Доктор: </label>
                        <input class="speciali_input_doctor" id=" login" value="<?= $doctor_last_name . " " . substr($doctor_first_name, 0, 2)
        . "." . substr($doctor_patronymic_name, 0, 2) . "." ?>" readonly>
                    </div>

                    <div class="box">
                        <label class="speciali_label_doctor" for="login">Дата: </label>
                        <input class="speciali_input_doctor" id=" login" value="<?= $date ?>" name="date" readonly>

                    </div>
                </div>



                <button class="doctor_submit" type="submit">Добавить запись</button>

            </form>



        </div>





    </div>
    </div>
</body>

</html>


<?php

} else {
    ?>
<?php
    $id_talone = $_POST['id_talone'];
    $id_patient = $_POST['id_patient'];
    $id_doctor = $_POST['id_doctor'];
    $date = $_POST['date'];
    $patient_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `patient`
WHERE `id_patient` = '$id_patient'"));

    $patient_first_name = $patient_name[0][0];
    $patient_last_name = $patient_name[0][1];
    $patient_patronymic_name = $patient_name[0][2];

    $doctor_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `doctor`
WHERE `id_doctor` = '$id_doctor'"));

    $doctor_first_name = $doctor_name[0][0];
    $doctor_last_name = $doctor_name[0][1];
    $doctor_patronymic_name = $doctor_name[0][2];
?>
<?php





?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/add_appointment.css" type="text/css"><!--для обнуления-->

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">

            <a class="navbar_exit" href="lk_doctor.php">Вернуться в личный кабинет</a>

        </nav>
        <div class="content">


            <span class="doctor_title">Добавить запись в ЭКП пациента: <span style="color: #EC5863; margin-left: 20px;">
                    <?= $patient_last_name . " " . substr($patient_first_name, 0, 2) . "." .
            substr($patient_patronymic_name, 0, 2) . "." ?>
                </span></span>
            <form class="doctor_form" action="uppload/add_appointment.php" method="post">
                <input hidden name="id_patient" value="<?= $id_patient ?>">
                <input hidden name="id_talone" value="<?= $id_talone ?>">
                <input hidden name="id_doctor" value="<?= $id_doctor ?>">

                <input required class="speciali_input1" type="text" name="diagnosis" placeholder="Введите диагноз"
                    maxlength="70">

                <textarea required class="speciali_input" name="recomendation" placeholder="Введите рекомендации"
                    maxlength="255"></textarea>
                <div class="mother_box">
                    <div class="box">
                        <label class="speciali_label_doctor" for="doctor">Доктор: </label>
                        <input class="speciali_input_doctor" id=" login" value="<?= $doctor_last_name . " " . substr($doctor_first_name, 0, 2)
        . "." . substr($doctor_patronymic_name, 0, 2) . "." ?>" readonly>
                    </div>

                    <div class="box">
                        <label class="speciali_label_doctor" for="login">Дата: </label>
                        <input class="speciali_input_doctor" id=" login" value="<?= $date ?>" name="date" readonly>

                    </div>
                </div>



                <button class="doctor_submit" type="submit">Добавить запись</button>

            </form>



        </div>





    </div>
    </div>
</body>

</html>
<?php
}