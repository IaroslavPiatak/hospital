<?php
require_once 'connection.php';

?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет администратора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/lk_admin.css" type="text/css">
</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">
            <a class="navbar_a" href="add_doctor.php">Добавить врача</a>
            <a class="navbar_a" href="reg1.php">Добавить пациента</a>
            <a class="navbar_exit" href="uppload/logout.php">Выйти из личного кабинета</a>

        </nav>
        <div class="patient_status">
            <span class="doctor_title">Список пациентов по статусу</span>
            <div class="patient_status_box">
                <?php
                $status = mysqli_query($connect, "SELECT `name_status` FROM `status`");
                $status = mysqli_fetch_all($status);



                $status_number = mysqli_query($connect, "SELECT COUNT(*) FROM `status`");
                $status_number = mysqli_fetch_all($status_number);


                for ($i = 0; $i < $status_number[0][0]; $i++) {

                    echo '<form class = "doctor_form" action="patient_cout.php" method = "post">
                <div>
                <label  class="speciali_label" for="status">Статус: </label>
                <input class="speciali_input" id="status" type="text" name="status" value="' . $status[$i][0] . '"readonly>
                </div>
              
                <button class = "doctor_submit" type = "submit">Подробнее</button>  
                </form>';
                }
                ?>
            </div>


        </div>

        <div class="doctor" id="specialization">
            <span class="doctor_title">Выберите специальность, для перехода к списку врачей</span>
            <div class="doctor_box">
                <?php
            $specialization = mysqli_query($connect, "SELECT `name_specialization` FROM `specialization`");
            $specialization = mysqli_fetch_all($specialization);



            $specialization_number = mysqli_query($connect, "SELECT COUNT(*) FROM `specialization`");
            $specialization_number = mysqli_fetch_all($specialization_number);


            for ($i = 0; $i < $specialization_number[0][0]; $i++) {

                echo '<form class = "doctor_form" action="doctor_cout.php" method = "post">
              
                <label  class="speciali_label" for="specialization">Специализация: </label>
                <input class="speciali_input" id="specialization" type="text" name="specialization" value="' . $specialization[$i][0] . '"readonly>
              
                <button class = "doctor_submit" type = "submit">Перейти в ЛК</button>  
                </form>';
            }
            ?>
            </div>
        </div>
    </div>
</body>

</html>