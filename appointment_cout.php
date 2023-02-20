<?php
require_once 'connection.php';
$action = $_POST['action']; // смотрим, получаемое действие


if ($action == 'doctor_view_appointment') { // если смотрит доктор
?>
<?php
    $id_patient = $_POST['id_patient'];

    $appointment = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM `appointment` WHERE `id_patient` = '$id_patient'"));
    $appointment_count = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*)FROM `appointment` WHERE `id_patient` = '$id_patient'
ORDER BY `date`"))[0][0];


?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/appointment_cout.css" type="text/css"><!--для обнуления-->

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">
            <?php
    echo '<a class="navbar_exit" href="lk_doctor.php">Вернуться в личный кабинет</a>';

            ?>

        </nav>
        <div class="content">
            <?php

    for ($i = 0; $i < $appointment_count; $i++) {
        $data = $appointment[$i][6];
        $id_doctor = $appointment[$i][5];
        $doctor_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `doctor` WHERE `id_doctor` = '$id_doctor'"));
        $doctor_first_name = $doctor_name[$i][0];
        $doctor_last_name = $doctor_name[$i][1];
        $doctor_patronymic_name = $doctor_name[$i][2];
        $recomendation = $appointment[$i][4];
        $diagnosid = $appointment[$i][3];
        echo '
                <div class = "big_box">
                <div>
                <span class = "label">Диагноз:</span>' . '<span class = "label1">' . $diagnosid . '</span>
                </div>

                <div>
                <span class = "label">Рекомендации:</span>' . '<span class = "label1">' . $recomendation . '</span>
                </div>

                <div>
                <span class = "label">Доктор:</span>' . '<span class = "label1">' . $doctor_last_name . " " . substr($doctor_first_name, 0, 2) . "." . substr($doctor_patronymic_name, 0, 2) . "." . '</span>
                </div>

                <div>
                <span class = "label">Дата:</span>' . '<span class = "label1">' . $data . '</span>
                </div>
                </div>
                ';
    }
            ?>
        </div>
</body>

</html>

<?php

} else if ($action == 'doctor_view_analyz') { // просмотр доктором анализов
?>
<?php

    $id_patient = $_POST['id_patient'];

    $anamyz_count = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `analyzes` WHERE `id_patient` = '$id_patient'"))[0][0];

    if ($anamyz_count == 0) {
?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/appointment_cout.css" type="text/css"><!--для обнуления-->

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">
            <?php
        echo '<form action = "add_appointment.php" method = "post">
            <input hidden name = "action" value = "add_analyz">
            <input hidden name = "date" value = "' . getdate()['year'] . '-' . getdate()['mon'] . '-' . getdate()['mday'] . '">
            <input hidden name = "id_patient" value = "' . $id_patient . '">
            <button type = "submit" class="navbar_a_button">Добавить анализ</button>
            </form>';
        echo '<a class="navbar_exit" href="lk_doctor.php">Вернуться в личный кабинет</a>';

            ?>

        </nav>
        <div class="content">
            <?php
        echo '<span class = "warrning">Анализов у данного пациента пока нет</span>';
            ?>
        </div>
</body>

</html>
<?php

    } else {
?>
<?php
        $analyz = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM `analyzes` WHERE `id_patient` =
        '$id_patient'"));


?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/appointment_cout.css" type="text/css"><!--для обнуления-->

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">
            <?php
        echo '<form action = "add_appointment.php" method = "post">
        <input hidden name = "action" value = "add_analyz">
        <input hidden name = "date" value = "' . getdate()['year'] . '-' . getdate()['mon'] . '-' . getdate()['mday'] . '">
        <input hidden name = "id_patient" value = "' . $id_patient . '">
        <button type = "submit" class="navbar_a_button">Добавить анализ</button>
        </form>
        <a class="navbar_exit" href="lk_doctor.php">Вернуться в личный кабинет</a>';

            ?>

        </nav>
        <div class="content">
            <?php

        for ($i = 0; $i < $anamyz_count; $i++) {
            $name_analyz = $analyz[$i][2];
            $result_analyz = $analyz[$i][3];
            $date = $analyz[$i][4];
            echo '
                <div class = "big_box">
                <div>
                <span class = "label">Название анализа:</span>' . '<span class = "label1">' . $name_analyz . '</span>
                </div>

                <div>
                <span class = "label">Результаты анализа:</span>' . '<span class = "label1">' . $result_analyz . '</span>
                </div>

               
                <div>
                <span class = "label">Дата:</span>' . '<span class = "label1">' . $date . '</span>
                </div>
                </div>
                ';
        }
            ?>
        </div>
</body>

</html>
<?php

    }
?>





<?php

} else if ($action == 'doctor_view_surveys') { // просмотр доктором обследований
?>
<?php

    $id_patient = $_POST['id_patient'];

    $surveys_count = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `surveys` WHERE `id_patient` = '$id_patient'"))[0][0];

    if ($surveys_count == 0) {
    ?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/appointment_cout.css" type="text/css"><!--для обнуления-->

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">
            <?php
        echo '<form action = "add_appointment.php" method = "post">
           <input hidden name = "action" value = "add_survey">
           <input hidden name = "date" value = "' . getdate()['year'] . '-' . getdate()['mon'] . '-' . getdate()['mday'] . '">
           <input hidden name = "id_patient" value = "' . $id_patient . '">
           <button type = "submit" class="navbar_a_button">Добавить обследование</button>
           </form>';
        echo '<a class="navbar_exit" href="lk_doctor.php">Вернуться в личный кабинет</a>';

           ?>

        </nav>
        <div class="content">
            <?php
        echo '<span class = "warrning">Обследований у данного пациента пока нет</span>';
           ?>
        </div>
</body>

</html>
<?php

    } else {
?>
<?php
        $surveyes = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM `surveys` WHERE `id_patient` =
       '$id_patient'"));


?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/appointment_cout.css" type="text/css"><!--для обнуления-->

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">
            <?php
        echo '<form action = "add_appointment.php" method = "post">
           <input hidden name = "action" value = "add_survey">
           <input hidden name = "date" value = "' . getdate()['year'] . '-' . getdate()['mon'] . '-' . getdate()['mday'] . '">
           <input hidden name = "id_patient" value = "' . $id_patient . '">
           <button type = "submit" class="navbar_a_button">Добавить обследование</button>
           </form>';
        echo '<a class="navbar_exit" href="lk_doctor.php">Вернуться в личный кабинет</a>';

           ?>

        </nav>
        <div class="content">
            <?php

        for ($i = 0; $i < $surveys_count; $i++) {
            $name_surveyes = $surveyes[$i][2];
            $result_surveyes = $surveyes[$i][3];
            $date = $surveyes[$i][4];
            echo '
               <div class = "big_box">
               <div>
               <span class = "label">Название обследоваия:</span>' . '<span class = "label1">' . $name_surveyes . '</span>
               </div>

               <div>
               <span class = "label">Результаты обследования:</span>' . '<span class = "label1">' . $result_surveyes . '</span>
               </div>

              
               <div>
               <span class = "label">Дата:</span>' . '<span class = "label1">' . $date . '</span>
               </div>
               </div>
               ';
        }
           ?>
        </div>
</body>

</html>
<?php

    }
?>

<?php
} else {
    ?>
<?php
    $id_patient = $_POST['id_patient'];

    $appointment = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM `appointment` WHERE `id_patient` = '$id_patient'"));
    $appointment_count = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*)FROM `appointment` WHERE `id_patient` = '$id_patient'
ORDER BY `date`"))[0][0];





?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/appointment_cout.css" type="text/css"><!--для обнуления-->

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">
            <?php
    if ($role == 3)
        echo ' <a class="navbar_exit" href="lk_patient.php">Вернуться в личный кабинет</a>';
    else
        echo ' <a class="navbar_exit" href="lk_patient.php">Вернуться в личный кабинет</a>';

            ?>

        </nav>
        <div class="content">
            <?php

    for ($i = 0; $i < $appointment_count; $i++) {
        $data = $appointment[$i][6];
        $id_doctor = $appointment[$i][5];
        $doctor_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `doctor` WHERE `id_doctor` = '$id_doctor'"));
        $doctor_first_name = $doctor_name[$i][0];
        $doctor_last_name = $doctor_name[$i][1];
        $doctor_patronymic_name = $doctor_name[$i][2];
        $recomendation = $appointment[$i][4];
        $diagnosid = $appointment[$i][3];
        echo '
                <div>
                <span class = "label">Диагноз:</span>' . '<span class = "label1">' . $diagnosid . '</span>
                <div>

                <div>
                <span class = "label">Рекомендации:</span>' . '<span class = "label1">' . $recomendation . '</span>
                <div>

                <div>
                <span class = "label">Доктор:</span>' . '<span class = "label1">' . $doctor_last_name . " " . substr($doctor_first_name, 0, 2) . "." . substr($doctor_patronymic_name, 0, 2) . "." . '</span>
                <div>

                <div>
                <span class = "label">Дата:</span>' . '<span class = "label1">' . $data . '</span>
                <div>
                ';
    }
            ?>
        </div>
</body>

</html>
<?php


}
?>