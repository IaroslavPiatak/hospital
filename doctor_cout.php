<?php
require_once 'connection.php';
$id_specialization = $_POST['specialization'];
$id_specialization = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_specialization` FROM `specialization`
WHERE `name_specialization` = '$id_specialization'"))[0][0];


?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/doctor_cout.css" type="text/css"><!--для обнуления-->
    
</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">
            <a class="navbar_a" href="add_doctor.php">Добавить врача</a>
            <a class="navbar_exit" href="lk_admin.php #specialization">Вернуться в личный кабинет</a>
        </nav>
        <div class="content">
          
            <?php
            echo '<span class="doctor_title">Спиcок врачей специальности: ' .'<span>'.$_POST['specialization']. '</span> ' .'</span>';
            $doctor = mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name`, `name_smena` , `name_cabinet` FROM `doctor`
            JOIN `smena` ON `smena`.`id_smena` = `doctor`.`id_smena`
            JOIN `cabinet` ON `cabinet`.`id_cabinet` = `doctor`.`cabinet`
            WHERE `id_specialization` = '$id_specialization'
            ORDER BY `name_cabinet`");
            $doctor = mysqli_fetch_all($doctor);
         



            $doctor_list_number = mysqli_query($connect, "SELECT COUNT(*) FROM `doctor` WHERE `id_specialization` = '$id_specialization'");
            $doctor_list_number = mysqli_fetch_all($doctor_list_number);
        

         

            for ($i = 0; $i < $doctor_list_number[0][0]; $i++) {
    
                echo '<form class = "doctor_form" action="lk_doctor.php" method = "post">
                <div class = "box">
                <label  class="speciali_label1" for="last_name">Врач: </label>
                <input class="speciali_input1" id="last_name" type="text" value="'. $doctor[$i][1] . ' ' . substr($doctor[$i][0],0,2) . '.' . ' ' .  substr($doctor[$i][2],0,2) . '.'  . '"readonly>
                </div>
            
                <input class="speciali_input1" id="last_name" type="text" name="last_name" value="'. $doctor[$i][1] . '"readonly hidden>
                <input class="speciali_input1" id="last_name" type="text" name="first_name" value="'. $doctor[$i][0] . '"readonly hidden>
                <input class="speciali_input1" id="last_name" type="text" name="patronymic_name" value="'. $doctor[$i][2] . '"readonly hidden>
              

                <div class = "box">
                <label  class="speciali_label2" for="smena">График работы: </label>
                <input class="speciali_input2" id="smena" type="text" name="smena" value="'. $doctor[$i][3]. '"readonly>
                </div>
             

                <div class = "box"> 
                <label  class="speciali_label3" for="cabinet">Кабинет: </label>
                <input class="speciali_input3" id="cabinet" type="text" name="cabinet" value="'. $doctor[$i][4]. '"readonly>
                </div>
            
                <button class = "doctor_submit" type = "submit">Перейти в ЛК</button>  
                </form>';


            }
       
            ?>


        </div>
</body>

</html>