<?php
session_start(); // запускаем сессии, подключаем файл для коннекта с БД
require_once 'connection.php';



?>

<html>

<head>
    <title>Личный кабинет пациента</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/lk_patient_change_admin.css" type="text/css"> <!--для обнуления-->
</head>

<body>
    <div class="container"> <!--Главный контейнер-->
        <nav class="navbar"> <!--Навигация-->
            
        <a class="navbar_exit" href="lk_admin.php">Вернуться в личный кабинет</a>
        </nav>
        <div class="header"> <!--Шапка-->
            <?php // запуск скрипта по извлечению информации
            $id_patient = $_POST['id_patient'];
            $id_user = (mysqli_fetch_all(mysqli_query($connect, "SELECT `user_id` FROM `patient` WHERE `id_patient` = '$id_patient'"))[0][0]);
            $login = mysqli_fetch_all(mysqli_query($connect, "SELECT `login` FROM `user` WHERE `id_user` = '$id_user'"))[0][0];
            $password = mysqli_fetch_all(mysqli_query($connect, "SELECT `password` FROM `user` WHERE `id_user` = '$id_user'"))[0][0];
            $login_and_password = mysqli_query($connect, "SELECT * FROM `user` WHERE `login` = '$login' AND `password` = '$password'"); // из таблицы user, вытаскиваем id_user , пароль. логин. 
            $login_and_password = mysqli_fetch_all($login_and_password); // все полученное формируем в массив
            foreach ($login_and_password as $login_and_password) { // перебираем массив из полученных элементов 
                $id_user = $login_and_password[0]; // вытаскиваем id_user
                $login_patient = $login_and_password[1]; // логин пациента
                $password_patient = $login_and_password[2]; // пароль пациента
            
            }
            $id_status = mysqli_fetch_all(mysqli_query($connect, " SELECT `status` FROM `patient` WHERE `id_patient` = '$id_patient'"))[0][0];  
            $check_user_id = mysqli_fetch_all(mysqli_query($connect, " SELECT `name_status` FROM `status` 
            JOIN `patient` ON `status`.`id_status` = `patient`.`status`
            WHERE `patient`.`status` = '$id_status'"))[0][0]; // соединяем 2 таблицы и вытаскиваем статус
        
            ?>



            <form class="speciali" action="change_status_admin.php" method="post"> <!--форма, которую будет менять админ-->
            <div class="status_block">
                <div class="block">
                    <label class="speciali_label" for="login">Ваш логин: </label>
                    <input class="speciali_input" id="login" type="text" name="login" value="<?= $login_patient ?>"
                        readonly>
                </div>
                <!--через value задаем изначальное значение-->
                <div class="block">
                    <label class="speciali_label for=" login">Ваш пароль: </label>
                    <input class="speciali_input id=" login" type="text" name="password"
                        value="<?= $password_patient ?>" readonly>
                </div>
                <div class="block">
                <label class="speciali_label for=" login">Ваш cтатус: </label>
                <input class="speciali_input id=" login" type="text" name="status" value="<?= $check_user_id ?>"
                    readonly>
                </div>
                <div class="block_submit">
                <button type="submit" class="speciali_submit">Изменить</button>
                <input type="hidden" name="id_user" value="<?= $id_user ?>">
                </div>
            </div>
                
            </form>



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

            <form class="info_form" action="change_info_admin.php" method="post">
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
                <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="mip_number" type="text" name="mip_number" value="<?= $mip_number ?>" readonly>
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="passport">Серия и номер паспорта: </label>
                <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="passport" type="text" name="passport" value="<?= $passport ?>" readonly>
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="address">Домашний адрес: </label>
                <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="address" type="text" name="address" value="<?= $address ?>" readonly>
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="phone_number">Номер телефона: </label>
                <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="phone_number" type="text" name="phone_number" value="<?= $phone_number ?>" readonly>
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="data_of_doctor">Вы прикреплены к врачу: </label>
                <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="data_of_doctor" type="text" name="data_of_doctor" value="<?= $last_name_doctor . ' '. substr($first_name_doctor,0,2) . '.' . substr($patronymic_name_doctor,0,2) . '.' ?>" readonly>
                </div>

                <div class="block_info">
                <label  class="speciali_label" for="my">Ваше МУ: </label>
                <input class="speciali_input" id="my" type="text" name="data_of_doctor" value="<?='Котель'?>" readonly>
                </div>

                <input type="hidden" name="id_user" value="<?= $id_user ?>">
                <!--Кнопка изменить-->
                <div class="block_info_button">
                <button type="submit" class="info_submit">Изменить</button>
                <div>
            </form>


        </div>

</body>