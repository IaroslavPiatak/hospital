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


?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/change_info_doctor.css" type="text/css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar"> <!--Навигация-->
            <a class="navbar_a" href="index.php">Главная</a>
            <a class="navbar_exit" href="uppload/logout.php">Выйти из личного кабинета</a>
        </nav>
        <div class="info_doctor">
            <div class="foto_doctor"></div>
            <form class="profile_doctor" action="uppload/change_info_doctor.php" method = "post">
                <div class="block_info">
                    <label class="speciali_label" for="last_name">Фамилия: </label>
                    <input class="speciali_input" id="last_name" type="text" name="last_name"
                        value="<?= $doctor_last_name ?>" readonly>
                </div>
                <div class="block_info">
                    <label class="speciali_label" for="first_name">Имя: </label>
                    <input class="speciali_input" id="first_name" type="text" name="first_name"
                        value="<?= $doctor_first_name ?>" readonly>
                </div>
                <div class="block_info">
                    <label class="speciali_label" for="patronymic_name">Отчество: </label>
                    <input class="speciali_input" id="patronymic_name" type="text" name="patronymic_name"
                        value="<?= $doctor_patronymic_name ?>" readonly>
                </div>
                <div class="block_info">
                    <label class="speciali_label" for="cabinet">Кабинет: </label>
                    <select class="cabinet_selected" name="cabinet">
                        <?php
                        $cabinet = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM `cabinet`"));
                        $cabinet_count = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `cabinet`"))[0][0];
                        for($i = 0; $i < $cabinet_count; $i++)
                        {
                            echo '
                            <option class="speciali_input" value = "'. $cabinet[$i][0] .'">'. $cabinet[$i][1] .'</option>';

                        }       ?>
                           
                        </select>
                    <div class="block_info">
                        <label class="speciali_label" for="">Специализация: </label>
                        <input class="speciali_input" id="specialization" type="text" name="specialization"
                            value="<?= $specialization ?>" readonly>
                    </div>
                    <div class="block_info">
                        <label class="speciali_label" for="">Смена: </label>
                        <select class="cabinet_selected" name="smena">
                            <option value = '1'>8:00 - 12:00</option>
                            <option value="2">13:00 - 17:00</option>
                        </select>
                    </div>
                    <div class="block_info">
                        <label class="speciali_label" for="">Логин: </label>
                        <input class="speciali_input" id="login" type="text" name="login" value="<?= $login ?>"
                            readonly>
                    </div>
                    <div class="block_info">
                        <label class="speciali_label" for="">Пароль: </label>
                        <input class="speciali_input" id="password" type="password" name="password"
                            value="<?= $password ?>" readonly>
                    </div>
                    <div class="block_info1">
                    <button type="submit" class="info_submit">Изменить</button>
                    </div>
                 
            </form>
        </div>
        
      
    </div>
</body>