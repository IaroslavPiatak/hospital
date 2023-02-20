<?php
require_once 'connection.php'; 
$id_user = $_POST['id_user'];
$role = mysqli_fetch_all(mysqli_query($connect, "SELECT `role` FROM `user` WHERE `id_user` = '$id_user'"))[0][0];



?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/talone_cout.css" type="text/css"><!--для обнуления-->

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar"> <!--Элементы Navbar зависит от роли-->
            <?php
            if ($role == 3)
                echo ' <a class="navbar_exit" href="lk_patient.php">Вернуться в личный кабинет</a>';
            else
                echo ' <a class="navbar_exit" href="lk_doctor.php">Вернуться в личный кабинет</a>';

            ?>
           
        </nav>
        <div class="content">
            <?php
            if ($role == 3) { // если на эту страницу попал пациент
                $id_patient = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_patient` FROM `patient`
                WHERE `user_id` = '$id_user'"))[0][0];
                $yesterday_or_next = $_POST['yesterday_or_next'];
                $today_data = getdate()['year'] . '.' . getdate()['mon'] . '.' . getdate()['mday'];
                if ($yesterday_or_next == 1) // предстоящие приемы для пациента
                {
                    $count_talone = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `talone` WHERE `id_patient` = '$id_patient' AND
                    `date` > '$today_data'"))[0][0];
                    if ($count_talone == 0)
                    ?>
                        <span class = "warrning">У вас нет предстоящих приемов</span>;
                        <?php

                    $talone = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_doctor_name`, `id_spetialization`, `id_cabinet`, `date`, `time`
                    FROM `talone` WHERE `id_patient` = '$id_patient' AND
                    `date` > '$today_data' "));


                    for ($i = 0; $i < $count_talone; $i++) {
                        $id_doctor = $talone[$i][0];
                        $id_specialization = $talone[$i][1];
                        $id_cabinet = $talone[$i][2];
                        $date = $talone[$i][3];
                        $time = $talone[$i][4];
                        $doctor_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name`  FROM `doctor` 
                        WHERE `doctor`.`id_doctor` = '$id_doctor'"));
                        $specialization = mysqli_fetch_all(mysqli_query($connect, "SELECT `name_specialization` FROM `specialization` 
                        WHERE `id_specialization` = '$id_specialization'"))[0][0];
                        $doctor_first_name = $doctor_name[0][0];
                        $doctor_last_name = $doctor_name[0][1];
                        $doctor_patronymic_name = $doctor_name[0][2];
                        $id_cabinet = mysqli_fetch_all(mysqli_query($connect, "SELECT `name_cabinet` FROM `cabinet` 
                        WHERE `id_cabinet` = '$id_cabinet'"))[0][0];




                        echo '
                        <div class = "talon">
                        <div class = "talon_title">
                        <p>Ваш талончик на прием</p>
                        </div>
                        <div class = "talon_text">
                        <label>Врач: ' . $doctor_last_name . ' ' . substr($doctor_first_name, 0, 2) . '.' . substr($doctor_patronymic_name, 0, 2) . '.' . '</label>
                        <label>' . $specialization . '</label>
                        <label>Кабинет: ' . $id_cabinet . '</label>
                        <label>Дата приема:   ' . $date . '</label>
                        <label>Время приема:   ' . $time . '</label>
                        </div>
                        </div>';
                    }
                } 
                
                else if ($yesterday_or_next == 3) // приемы на сегодня для пациента 
                {
                    $count_talone = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `talone` WHERE `id_patient` = '$id_patient' AND
                    `date` > '$today_data'"))[0][0];
                    if ($count_talone == 0)
                        echo '<span class = "warrning">У вас нет талонов на сегодня</span>';

                    $talone = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_doctor_name`, `id_spetialization`, `id_cabinet`, `date`, `time`
                    FROM `talone` WHERE `id_patient` = '$id_patient' AND
                    `date` = '$today_data' "));


                    for ($i = 0; $i < $count_talone; $i++) {
                        $id_doctor = $talone[$i][0];
                        $id_specialization = $talone[$i][1];
                        $id_cabinet = $talone[$i][2];
                        $date = $talone[$i][3];
                        $time = $talone[$i][4];
                        $doctor_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name`  FROM `doctor` 
                        WHERE `doctor`.`id_doctor` = '$id_doctor'"));
                        $specialization = mysqli_fetch_all(mysqli_query($connect, "SELECT `name_specialization` FROM `specialization` 
                        WHERE `id_specialization` = '$id_specialization'"))[0][0];
                        $doctor_first_name = $doctor_name[0][0];
                        $doctor_last_name = $doctor_name[0][1];
                        $doctor_patronymic_name = $doctor_name[0][2];
                        $id_cabinet = mysqli_fetch_all(mysqli_query($connect, "SELECT `name_cabinet` FROM `cabinet` 
                        WHERE `id_cabinet` = '$id_cabinet'"))[0][0];




                        echo '
                        <div class = "talon">
                        <div class = "talon_title">
                        <p>Ваш талончик на прием</p>
                        </div>
                        <div class = "talon_text">
                        <label>Врач: ' . $doctor_last_name . ' ' . substr($doctor_first_name, 0, 2) . '.' . substr($doctor_patronymic_name, 0, 2) . '.' . '</label>
                        <label>' . $specialization . '</label>
                        <label>Кабинет: ' . $id_cabinet . '</label>
                        <label>Дата приема:   ' . $date . '</label>
                        <label>Время приема:   ' . $time . '</label>
                        </div>
                        </div>';
                    }
                }
                
                else { // прошедшие приемы для пациента
                    $count_talone = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `talone` WHERE `id_patient` = '$id_patient' AND
                    `date` < '$today_data'"))[0][0];

                    $talone = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_doctor_name`, `id_patient`, `id_cabinet`, `date`, `time`
                    FROM `talone` WHERE `id_patient` = '$id_patient' AND
                    `date` < '$today_data' "));

       
                    for ($i = 0; $i < $count_talone; $i++) {
                        $id_doctor = $talone[$i][0];
                        $id_specialization = $talone[$i][1];
                        $id_cabinet = $talone[$i][2];
                        $date = $talone[$i][3];
                        $time = $talone[$i][4];
                        $doctor_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name`  FROM `doctor` 
                        WHERE `doctor`.`id_doctor` = '$id_doctor'"));
                        $specialization = mysqli_fetch_all(mysqli_query($connect, "SELECT `name_specialization` FROM `specialization` 
                        WHERE `id_specialization` = '$id_specialization'"))[0][0];
                        $doctor_first_name = $doctor_name[0][0];
                        $doctor_last_name = $doctor_name[0][1];
                        $doctor_patronymic_name = $doctor_name[0][2];
                        $id_cabinet = mysqli_fetch_all(mysqli_query($connect, "SELECT `name_cabinet` FROM `cabinet` 
                        WHERE `id_cabinet` = '$id_cabinet'"))[0][0];




                        echo '
                        <div class = "talon">
                        <div class = "talon_title">
                        <p>Ваш талончик на прием</p>
                        </div>
                        <div class = "talon_text">
                        <label>Врач: ' . $doctor_last_name . ' ' . substr($doctor_first_name, 0, 2) . '.' . substr($doctor_patronymic_name, 0, 2) . '.' . '</label>
                        <label>' . $specialization . '</label>
                        <label>Кабинет: ' . $id_cabinet . '</label>
                        <label>Дата приема:   ' . $date . '</label>
                        <label>Время приема:   ' . $time . '</label>
                        </div>
                        </div>';
                    }

                }
            }

            else // вывод талонов для докторов
            {
                $id_doctor = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_doctor` FROM `doctor`
                WHERE `id_user` = '$id_user'"))[0][0];
                $yesterday_or_next = $_POST['yesterday_or_next'];
                $today_data = getdate()['year'] . '.' . getdate()['mon'] . '.' . getdate()['mday'];
                if ($yesterday_or_next == 1) // предстоящие приемы
                {
                    $count_talone = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `talone` WHERE `id_doctor_name` = '$id_doctor' AND
                    `date` > '$today_data'"))[0][0];

                    $talone = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_patient`, `id_cabinet`, `date`, `time`
                    FROM `talone` WHERE `id_doctor_name` = '$id_doctor' AND
                    `date` > '$today_data' "));

                    for ($i = 0; $i < $count_talone; $i++) {
                        $id_patient = $talone[$i][0];
                        $id_cabinet = $talone[$i][1];
                        $date = $talone[$i][2];
                        $time = $talone[$i][3];
                     
                        $patient_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name`  FROM `patient` 
                        WHERE `patient`.`id_patient` = '$id_patient'"));
                       
                        $patient_first_name = $patient_name[0][0];
                        $patient_last_name = $patient_name[0][1];
                        $patient_patronymic_name = $patient_name[0][2];
                        $id_cabinet = mysqli_fetch_all(mysqli_query($connect, "SELECT `name_cabinet` FROM `cabinet` 
                        WHERE `id_cabinet` = '$id_cabinet'"))[0][0];




                        echo '
                        <div class = "talon">
                        <div class = "talon_title">
                        <p>Талончик на прием</p>
                        </div>
                        <div class = "talon_text">
                        <label>Пациент: ' . $patient_last_name . ' ' . substr($patient_first_name, 0, 2) . '.' . substr($patient_patronymic_name, 0, 2) . '.' . '</label>
                        <label>Кабинет: ' . $id_cabinet . '</label>
                        <label>Дата приема:   ' . $date . '</label>
                        <label>Время приема:   ' . $time . '</label>
                        </div>
                        </div>';
                    }
                } else if ($yesterday_or_next == 3) { //приемы "на сегодня"
                    $count_talone = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `talone` WHERE `id_doctor_name` = '$id_doctor' AND
                    `date` = '$today_data'"))[0][0];

                    $talone = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_patient`, `id_cabinet`, `date`, `time`, `id_talone`
                    FROM `talone` WHERE `id_doctor_name` = '$id_doctor' AND
                    `date` = '$today_data' "));
                    for ($i = 0; $i < $count_talone; $i++) {
                        $id_patient = $talone[$i][0];
                        $id_cabinet = $talone[$i][1];
                        $date = $talone[$i][2];
                        $time = $talone[$i][3];
                        $id_talone = $talone[$i][4];

                        $patient_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name`  FROM `patient` 
                        WHERE `patient`.`id_patient` = '$id_patient'"));

                        $patient_first_name = $patient_name[0][0];
                        $patient_last_name = $patient_name[0][1];
                        $patient_patronymic_name = $patient_name[0][2];
                        $id_cabinet = mysqli_fetch_all(mysqli_query($connect, "SELECT `name_cabinet` FROM `cabinet` 
                        WHERE `id_cabinet` = '$id_cabinet'"))[0][0];




                        echo '
                        <div class = "talon">
                        <div class = "talon_title">
                        <p>Талончик на прием</p>
                        </div>
                        <div class = "talon_text">
                        <label>Пациент: ' . $patient_last_name . ' ' . substr($patient_first_name, 0, 2) . '.' . substr($patient_patronymic_name, 0, 2) . '.' . '</label>
                        <label>Кабинет: ' . $id_cabinet . '</label>
                        <label>Дата приема:   ' . $date . '</label>
                        <label>Время приема:   ' . $time . '</label>
                        <form action = "add_appointment.php" method = "post">
                        <input value = "' . $id_patient . '" name = "id_patient" hidden>
                        <input value = "' . $id_doctor . '" name = "id_doctor" hidden>
                        <input value = "' . $date . '" name = "date" hidden>
                        <input value = "' . $id_talone . '" name = "id_talone" hidden>
                        <button type = "submit" class="talone_button">Открыть ЭКП</button>
                        </form>
                        </div>
                        </div>';
                    }
                }
                
                
                
                else { // прошедшие приемы для докторов
                    $count_talone = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `talone` WHERE `id_doctor_name` = '$id_doctor' AND
                    `date` < '$today_data'"))[0][0];

                    $talone = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_patient`, `id_cabinet`, `date`, `time`
                    FROM `talone` WHERE `id_doctor_name` = '$id_doctor' AND
                    `date` < '$today_data' "));

                    for ($i = 0; $i < $count_talone; $i++) {
                        $id_patient = $talone[$i][0];
                        $id_cabinet = $talone[$i][1];
                        $date = $talone[$i][2];
                        $time = $talone[$i][3];
                     
                        $patient_name = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name`  FROM `patient` 
                        WHERE `patient`.`id_patient` = '$id_patient'"));
                       
                        $patient_first_name = $patient_name[0][0];
                        $patient_last_name = $patient_name[0][1];
                        $patient_patronymic_name = $patient_name[0][2];
                        $id_cabinet = mysqli_fetch_all(mysqli_query($connect, "SELECT `name_cabinet` FROM `cabinet` 
                        WHERE `id_cabinet` = '$id_cabinet'"))[0][0];




                        echo '
                        <div class = "talon">
                        <div class = "talon_title">
                        <p>Талончик на прием</p>
                        </div>
                        <div class = "talon_text">
                        <label>Пациент: ' . $patient_last_name . ' ' . substr($patient_first_name, 0, 2) . '.' . substr($patient_patronymic_name, 0, 2) . '.' . '</label>
                        <label>Кабинет: ' . $id_cabinet . '</label>
                        <label>Дата приема:   ' . $date . '</label>
                        <label>Время приема:   ' . $time . '</label>
                        </div>
                        </div>';
                    }

                }
            }
                ?>
           
        </div>
</body>

</html>