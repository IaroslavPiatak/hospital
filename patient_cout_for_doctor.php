<?php
session_start();
require_once 'connection.php';
$id_doctor = $_POST['doctor_id'];
print_r($_SESSION);




?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/patient_cout.css" type="text/css"><!--для обнуления-->
    
</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">
            <a class="navbar_exit" href="lk_admin.php">Вернуться в личный кабинет</a>
        </nav>
        <div class="content">
          
            <?php
            echo '<span class="doctor_title">Спиcок закрепленных за вами пациентов</span>';
            $patient = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `patient`
            WHERE `id_doctor` = '$id_doctor'"));
          
         
            $patient_number = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `patient` WHERE `id_doctor` = '$id_doctor'"));


            print_r($id_doctor);
            for ($i = 0; $i < $patient_number[0][0]; $i++) {
                $patient_full_name = $patient[$i][1] . ' ' . substr($patient[$i][0],0,2). '.' . substr($patient[$i][2],0,2) . '.';
                $last_name = $patient[$i][1];
                $first_name = $patient[$i][0];
                $patronymic_name = $patient[$i][2];
                $id_patient = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_patient` FROM `patient` WHERE `last_name` = '$last_name' AND
                `first_name` = '$first_name' AND `patronymic_name` = '$patronymic_name'"))[0][0];
                echo '<form class = "doctor_form" action="lk_patient_change_admin.php" method = "post">
                <div>
                <label  class="speciali_label1" for="last_name">Пациент: </label>
                <input class="speciali_input1" id="last_name" type="text"  value="'. $patient_full_name . '"readonly>
                <input class="speciali_input1" id="last_name" type="text" name="id_patient" value="'. $id_patient . '"readonly hidden>
                </div>
            
                <button class = "doctor_submit" type = "submit">Перейти в ЛК</button>  
                </form>';


            }
            ?>
        </div>
</body>

</html>