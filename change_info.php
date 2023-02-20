<?php
session_start(); // запускаем сессии, подключаем файл для коннекта с БД
require_once 'connection.php';

?>

<html>

<head>
    <title>Личный кабинет пациента</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/change_info.css" type="text/css"> <!--для обнуления-->
</head>

<body>
    <div class="container"> <!--Главный контейнер-->
        <nav class="navbar"> <!--Навигация-->
            <a class="navbar_a" href="index.php">Главная</a>
            <a class="navbar_exit" href="uppload/logout.php">Выйти из личного кабинета</a>
        </nav>
        <div class="header"> <!--Шапка-->
            <?php // запуск скрипта по извлечению информации
            

            $login = $_SESSION['user_autorization']['login']; // вытаскиваем логин и пароль, которые получаем при авторизации 
            $password = $_SESSION['user_autorization']['password'];
            $login_and_password = mysqli_query($connect, "SELECT * FROM `user` WHERE `login` = '$login' AND `password` = '$password'"); // из таблицы user, вытаскиваем id_user , пароль. логин. 
            $login_and_password = mysqli_fetch_all($login_and_password); // все полученное формируем в массив
            foreach ($login_and_password as $login_and_password) { // перебираем массив из полученных элементов 
                $id_user = $login_and_password[0]; // вытаскиваем id_user
                $login_patient = $login_and_password[1]; // логин пациента
                $password_patient = $login_and_password[2]; // пароль пациента
            
            }

            $check_user_id = mysqli_query($connect, " SELECT `name_status` FROM `status` JOIN `patient` ON `status`.`id_status` = `patient`.`status`;"); // соединяем 2 таблицы и вытаскиваем статус
            $check_user_id = mysqli_fetch_all($check_user_id); // помещаем статус в массив
            foreach ($check_user_id as $check_user_id) { // перебираем массив из полученных элементов 
                $status_patient = $check_user_id[0]; // вытаскиваем статус
            
            }
            ?>



           

            <?php // вытаскиваем все данные о пациенте
            $data_of_patient = mysqli_query($connect, "SELECT `first_name`,`last_name`, `patronymic_name`,`date_of_birthday`,`mip_number`,`address`,`phone_number`,`passport`,`my` FROM `patient` WHERE `user_id` = '$id_user'");
            $data_of_patient = mysqli_fetch_all($data_of_patient);
            foreach ($data_of_patient as $data_of_patient) {
                $first_name = $data_of_patient[0];
                $last_name = $data_of_patient[1];
                $patronymic_name = $data_of_patient[2];
                $date_of_birthday = $data_of_patient[3];
                $mip_number = $data_of_patient[4];
                $address = $data_of_patient[5];
                $phone_number = $data_of_patient[6];
                $passport = $data_of_patient[7];
                $my = $data_of_patient[8];
            }
            // вытаскиваем врача пациента
            $doctor_of_patient = mysqli_query($connect, "SELECT `doctor`.`first_name`, `doctor`.`last_name`, `doctor`.`patronymic_name` FROM `doctor` JOIN `patient` ON `patient`.`id_doctor` = `doctor`.`id_doctor`;");
            $doctor_of_patient = mysqli_fetch_all($doctor_of_patient);
            foreach ($doctor_of_patient as $doctor_of_patient) {
                $first_name_doctor = $doctor_of_patient[0];
                $last_name_doctor = $doctor_of_patient[1];
                $patronymic_name_doctor = $doctor_of_patient[2];


            }
            ?>
        </div>
        <!--Блок с информацией о пациенте-->
        <div class='info'>
            <span class="info_title">Тут ваша информация</span>

            <form class="info_form" action="uppload/change_info.php" method="post">
                <!-- форма для будущих изменений данных пациентом -->
                <div class="block_info">
                <label  class="speciali_label" for="last_name">Фамилия: </label>
                <input class="speciali_input" id="last_name" type="text" name="last_name" value="<?= $last_name ?>" readonly>
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="first_name">Имя: </label>
                <input class="speciali_input" id="first_name" type="text" name="first_name" value="<?= $first_name ?>" readonly>
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="patronymic_name">Отчество: </label>
                <input class="speciali_input" id="patronymic_name" type="text" name="patronymic_name" value="<?= $patronymic_name ?>" readonly>
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="date_of_birthday">Дата рождения: </label>
                <input class="speciali_input" id="date_of_birthday" type="text" name="date_of_birthday" value="<?= $date_of_birthday ?>"readonly>
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="mip_number">Номер СМП: </label>
                <input  class="speciali_input_change" id="mip_number" type="number" name="mip_number" value="<?= $mip_number ?>" min="1000000000000000" max="9999999999999999" >
                </div>
                

                <div class="block_info">
                <label  class="speciali_label" for="passport">Серия и номер паспорта: </label>
                <input class="speciali_input_change" id="passport" type="number" name="passport" value="<?= $passport ?>" min="1000000000" max="9999999999">
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="address">Домашний адрес: </label>
                <input class="speciali_input_change" id="address" type="text" name="address" value="<?= $address ?>" maxlength="25" >
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="phone_number">Номер телефона: </label>
                <input class="speciali_input_change" id="phone_number" type="number" name="phone_number" value="<?= $phone_number ?>" min="80000000000" max="89999999999">
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="data_of_doctor">Вы прикреплены к врачу: </label>
                <select class="speciali_input" id="data_of_doctor" name = "doctor_id" >
                    <option selected="true" disabled="disabled">Выберите врача</option>
                    <?php
                    $id_specialization = (mysqli_fetch_all(mysqli_query($connect, "SELECT `id_specialization` FROM `specialization` WHERE `name_specialization` = 'Терапевт'"))[0][0]);
                    $id_specialization_count = (mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `doctor`
                    JOIN `specialization` ON `doctor`.`id_specialization` = `specialization`.`id_specialization`
                    WHERE `name_specialization` = 'Терапевт'"))[0][0]);
                    $doctor_select = mysqli_fetch_all(mysqli_query($connect, "SELECT `first_name`, `last_name`, `patronymic_name` FROM `doctor` WHERE `id_specialization` = '$id_specialization'"));
                    for ($i = 0; $i < $id_specialization_count; $i++)
                    {
                        $last_name_doctor = $doctor_select[$i][1];
                        $first_name_doctor = $doctor_select[$i][0];
                        $patronymic_name_doctor = $doctor_select[$i][2];
                        $id_doctor = (mysqli_fetch_all(mysqli_query($connect, "SELECT `id_doctor` FROM `doctor` WHERE `last_name` = '$last_name_doctor'
                        AND `first_name` = '$first_name_doctor' AND `patronymic_name` = '$patronymic_name_doctor'"))[0][0]);
                        echo '<option value = "'. $id_doctor .'">' . $doctor_select[$i][1] . " ". substr($doctor_select[$i][0],0,2). "." . substr($doctor_select[$i][2],0,2) . "." . '</option>';
                        
                    }

                    ?>
             

                </select> 
                </div>
   
                <div class="block_info">
                <label  class="speciali_label" for="my">Ваше МУ: </label>
                <input class="speciali_input" id="my" type="text" name="data_of_doctor" value="<?='Котель'?>" readonly>
                </div>

                <input type="hidden" name="id_user" value="<?= $id_user ?>">
                <!--Кнопка изменить-->
                <div class="block_info_button">
                <button type="submit" class="info_submit">Принять изменения</button>
                <div>
            </form>


        </div>

</body>