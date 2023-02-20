<?php
require_once 'connection.php';

$check_action = $_POST['check_action'];



if ($check_action == 'output_assigned_patients') {
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
            <a class="navbar_exit" href="lk_doctor.php">Вернуться в личный кабинет</a>
        </nav>
        <div class="content">

            <?php
            $id_doctor = $_POST['doctor_id'];
            echo '<span class="doctor_title">Спиcок закрепленных за вами пациентов</span>' ;
            $patient = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `patient`
            WHERE `id_doctor` = '$id_doctor'
            ORDER BY `last_name`"));
           

            $patient_number = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `patient` WHERE `id_doctor` = '$id_doctor'"))[0][0];
           

            for ($i = 0; $i < $patient_number[0][0]; $i++) {
                $patient_full_name = $patient[$i][1] . ' ' . substr($patient[$i][0],0,2). '.' . substr($patient[$i][2],0,2) . '.';
                $last_name = $patient[$i][1];
                $first_name = $patient[$i][0];
                $patronymic_name = $patient[$i][2];
                $id_patient = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_patient` FROM `patient` WHERE `last_name` = '$last_name' AND
                `first_name` = '$first_name' AND `patronymic_name` = '$patronymic_name'"))[0][0];
                echo '<form class = "doctor_form" action="lk_patient.php" method = "post">
                <div>
                <label  class="speciali_label1" for="last_name">Пациент: </label>
                <input class="speciali_input1" id="last_name" type="text"  value="'. $patient_full_name . '"readonly>
                <input class="speciali_input1" id="last_name" type="text" name="id_patient" value="'. $id_patient . '"readonly hidden>
                <input class="speciali_input1" id="last_name" type="text" name="action" value="add_electronic_list" readonly hidden>
                </div>
            
                <button class = "doctor_submit" type = "submit">Перейти в ЛК</button>  
                </form>';
            }
            ?>
        </div>
</body>
</html>

<?php
} else {
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
            $id_status = $_POST['status'];
            $id_status = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_status` FROM `status`
            WHERE `name_status` = '$id_status'"))[0][0];
    echo '<span class="doctor_title">Спиcок пациентов со статусом:' . '<span>' . $_POST['status'] . '</span>' . '</span>';
    $patient = mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `patient`
            JOIN `status` ON `patient`.`status` = `status`.`id_status`
            WHERE `patient`.`status` = '$id_status'
            ORDER BY `last_name`");
    $patient = mysqli_fetch_all($patient);




    $patient_number = mysqli_query($connect, "SELECT COUNT(*) FROM `patient` WHERE `status` = '$id_status'");
    $patient_number = mysqli_fetch_all($patient_number);




    for ($i = 0; $i < $patient_number[0][0]; $i++) {
        $patient_full_name = $patient[$i][1] . ' ' . substr($patient[$i][0], 0, 2) . '.' . substr($patient[$i][2], 0, 2) . '.';
        $last_name = $patient[$i][1];
        $first_name = $patient[$i][0];
        $patronymic_name = $patient[$i][2];
        $id_patient = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_patient` FROM `patient` WHERE `last_name` = '$last_name' AND
                `first_name` = '$first_name' AND `patronymic_name` = '$patronymic_name'"))[0][0];
        echo '<form class = "doctor_form" action="lk_patient_change_admin.php" method = "post">
                <div>
                <label  class="speciali_label1" for="last_name">Пациент: </label>
                <input class="speciali_input1" id="last_name" type="text"  value="' . $patient_full_name . '"readonly>
                <input class="speciali_input1" id="last_name" type="text" name="id_patient" value="' . $id_patient . '"readonly hidden>
                </div>
            
                <button class = "doctor_submit" type = "submit">Перейти в ЛК</button>  
                </form>';


    }
            ?>
        </div>
</body>

</html>
<?php
}

?>