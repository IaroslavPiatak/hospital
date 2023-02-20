<?php
session_start(); // запускаем сессии, подключаем файл для коннекта с БД
require_once 'connection.php';

$action = $_POST['action'];
if ($action == 'add_electronic_list') {
?>
<html>

<head>
    <title>Личный кабинет пациента</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/lk_patient.css" type="text/css"> <!--для обнуления-->
</head>

<body>
    <div class="container"> <!--Главный контейнер-->
        <nav class="navbar"> <!--Навигация-->

            <a class="navbar_exit" href="lk_doctor.php">Вернуться в личный кабинет</a>
        </nav>
        <div class="header_add_electronic_list"> <!--Шапка-->
            <?php // запуск скрипта по извлечению информации

    $id_patient = $_POST['id_patient'];
    $id_user = mysqli_fetch_all(mysqli_query($connect, "SELECT `user_id` FROM `patient` WHERE `id_patient` = '$id_patient'"))[0][0];

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
    $doctor_of_patient = mysqli_fetch_all(mysqli_query($connect, "SELECT `doctor`.`first_name`, `doctor`.`last_name`, `doctor`.`patronymic_name` 
            FROM `doctor` 
            JOIN `patient` ON `patient`.`id_doctor` = `doctor`.`id_doctor`
            WHERE `user_id` = '$id_user`'"));

    foreach ($doctor_of_patient as $doctor_of_patient) {
        $first_name_doctor = $doctor_of_patient[0];
        $last_name_doctor = $doctor_of_patient[1];
        $patronymic_name_doctor = $doctor_of_patient[2];


    }
            ?>
        </div>
        <!--Блок с информацией о пациенте-->
        <div class='info'>
            <span class="info_title">Информация о пациенте</span>

            <form class="info_form" action="change_info.php" method="post">
                <!-- форма для будущих изменений данных пациентом -->
                <div class="block_info">
                    <label class="speciali_label" for="last_name">Фамилия: </label>
                    <input class="speciali_input" id="last_name" type="text" name="last_name" value="<?= $last_name ?>"
                        readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="first_name">Имя: </label>
                    <input class="speciali_input" id="first_name" type="text" name="first_name"
                        value="<?= $first_name ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="patronymic_name">Отчество: </label>
                    <input class="speciali_input" id="patronymic_name" type="text" name="patronymic_name"
                        value="<?= $patronymic_name ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="date_of_birthday">Дата рождения: </label>
                    <input class="speciali_input" id="date_of_birthday" type="text" name="date_of_birthday"
                        value="<?= $date_of_birthday ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="mip_number">Номер СМП: </label>
                    <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="mip_number" type="text"
                        name="mip_number" value="<?= $mip_number ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="passport">Серия и номер паспорта: </label>
                    <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="passport" type="text"
                        name="passport" value="<?= $passport ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="address">Домашний адрес: </label>
                    <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="address" type="text"
                        name="address" value="<?= $address ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="phone_number">Номер телефона: </label>
                    <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="phone_number" type="text"
                        name="phone_number" value="<?= $phone_number ?>" readonly>
                </div>

                <div class="block_info">
                    <?php
    $check_doctor = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_doctor` FROM `patient`
                    WHERE `user_id` = '$id_user'"))[0][0];
    if ($check_doctor == null) {
        echo '<label class="speciali_label" for="data_of_doctor">Прикреплен к врачу: </label>
                        <input placeholder="Нажмите \'Изменить\'" class="speciali_input" id="data_of_doctor" type="text" 
                        name="data_of_doctor">';

    } else {
        echo '<label class="speciali_label" for="data_of_doctor">Прикреплен к врачу: </label>
                        <input placeholder="Нажмите Изменить" class="speciali_input" id="data_of_doctor" type="text"
                        value = "' . $last_name_doctor . ' ' . substr($first_name_doctor, 0, 2) . '.' . substr($patronymic_name_doctor, 0, 2) . '.' . '" 
                        name="data_of_doctor">';

    }
                    ?>

                </div>

                <div class="block_info">
                    <label class="speciali_label" for="my">МУ пациента: </label>
                    <input class="speciali_input" id="my" type="text" name="data_of_doctor" value="<?='Котель' ?>"
                        readonly>
                </div>

            </form>
        </div>




        <?php
    if ($check_doctor == null) {
        echo '
            <div class="ecp1">
            <span_ecp class="info_title">Для получения <br> электронной карты пациента, прикрепитесь к врачу.</span>       
            </div>';
    } else {

        echo '
            <div class="ecp1">
            <div>
            <span_ecp class="info_title_ecp">"Электронная карта пациента"</span>
            </div> 
            <div class = "ecp_box">
            <div class = "ecp_mini_box">            
            <span class = "speciali_label_talone">История приемов</span> 
            <form action = "appointment_cout.php" method = "post"> 
            <input hidden name = "id_patient" value = "' . $id_patient . '">
            <input hidden name = "action" value = "doctor_view_appointment">
            <button type = "submit" class="talone_button">Подробнее</button>
            </form>
            </div>
            
            <div class = "ecp_mini_box">     
            <span class = "speciali_label_talone">История анализов</span> 
            <form action = "appointment_cout.php" method = "post">        
            <input hidden name = "id_patient" value = "' . $id_patient . '">
            <input hidden name = "action" value = "doctor_view_analyz">
            <button type = "submit" class="talone_button">Подробнее</button>
            </form>
            </div>   

            <div class = "ecp_mini_box">     
            <span class = "speciali_label_talone">История обследований</span> 
            <form action = "appointment_cout.php" method = "post">        
            <input hidden name = "id_patient" value = "' . $id_patient . '">
            <input hidden name = "action" value = "doctor_view_surveys">
            <button type = "submit" class="talone_button">Подробнее</button>
            </form>
            </div>';

    }
        ?>



    </div>
</body>

<?php
} else {
?>
<html>

<head>
    <title>Личный кабинет пациента</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/lk_patient.css" type="text/css"> <!--для обнуления-->
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
        $id_patient = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_patient` FROM `patient` WHERE `user_id` = '$id_user'"))[0][0];

    }

    $check_user_id = mysqli_query($connect, " SELECT `name_status` FROM `status` JOIN `patient` ON `status`.`id_status` = `patient`.`status`  WHERE `id_patient` = '$id_patient'"); // соединяем 2 таблицы и вытаскиваем статус
    $check_user_id = mysqli_fetch_all($check_user_id); // помещаем статус в массив
    foreach ($check_user_id as $check_user_id) { // перебираем массив из полученных элементов 
        $status_patient = $check_user_id[0]; // вытаскиваем статус

    }
            ?>



            <form class="speciali" action="change_status.php" method="post"> <!--форма, которую будет менять админ-->
                <div class="status_block">
                    <div class="block">
                        <label class="speciali_label" for="login">Ваш логин: </label>
                        <input class="speciali_input" id="login" type="text" name="login" value="<?= $login_patient ?>"
                            readonly>
                    </div>
                    <!--через value задаем изначальное значение-->
                    <div class="block">
                        <label class="speciali_label for=" login">Ваш пароль: </label>
                        <input class="speciali_input id=" login" type="password" name="password"
                            value="<?= $password_patient ?>" readonly>
                    </div>
                    <div class="block">
                        <label class="speciali_label for=" login">Ваш cтатус: </label>
                        <input class="speciali_input id=" login" type="text" name="status"
                            value="<?= $status_patient ?>" readonly>
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
    $doctor_of_patient = mysqli_fetch_all(mysqli_query($connect, "SELECT `doctor`.`first_name`, `doctor`.`last_name`, `doctor`.`patronymic_name` 
            FROM `doctor` 
            JOIN `patient` ON `patient`.`id_doctor` = `doctor`.`id_doctor`
            WHERE `user_id` = '$id_user`'"));

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

            <form class="info_form" action="change_info.php" method="post">
                <!-- форма для будущих изменений данных пациентом -->
                <div class="block_info">
                    <label class="speciali_label" for="last_name">Фамилия: </label>
                    <input class="speciali_input" id="last_name" type="text" name="last_name" value="<?= $last_name ?>"
                        readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="first_name">Имя: </label>
                    <input class="speciali_input" id="first_name" type="text" name="first_name"
                        value="<?= $first_name ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="patronymic_name">Отчество: </label>
                    <input class="speciali_input" id="patronymic_name" type="text" name="patronymic_name"
                        value="<?= $patronymic_name ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="date_of_birthday">Дата рождения: </label>
                    <input class="speciali_input" id="date_of_birthday" type="text" name="date_of_birthday"
                        value="<?= $date_of_birthday ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="mip_number">Номер СМП: </label>
                    <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="mip_number" type="text"
                        name="mip_number" value="<?= $mip_number ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="passport">Серия и номер паспорта: </label>
                    <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="passport" type="text"
                        name="passport" value="<?= $passport ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="address">Домашний адрес: </label>
                    <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="address" type="text"
                        name="address" value="<?= $address ?>" readonly>
                </div>

                <div class="block_info">
                    <label class="speciali_label" for="phone_number">Номер телефона: </label>
                    <input placeholder="Нажмите 'Изменить'" class="speciali_input" id="phone_number" type="text"
                        name="phone_number" value="<?= $phone_number ?>" readonly>
                </div>

                <div class="block_info">
                    <?php
    $check_doctor = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_doctor` FROM `patient`
                    WHERE `user_id` = '$id_user'"))[0][0];
    if ($check_doctor == null) {
        echo '<label class="speciali_label" for="data_of_doctor">Вы прикреплены к врачу: </label>
                        <input placeholder="Нажмите \'Изменить\'" class="speciali_input" id="data_of_doctor" type="text" 
                        name="data_of_doctor">';

    } else {
        echo '<label class="speciali_label" for="data_of_doctor">Вы прикреплены к врачу: </label>
                        <input placeholder="Нажмите Изменить" class="speciali_input" id="data_of_doctor" type="text"
                        value = "' . $last_name_doctor . ' ' . substr($first_name_doctor, 0, 2) . '.' . substr($patronymic_name_doctor, 0, 2) . '.' . '" 
                        name="data_of_doctor">';

    }
                    ?>

                </div>

                <div class="block_info">
                    <label class="speciali_label" for="my">Ваше МУ: </label>
                    <input class="speciali_input" id="my" type="text" name="data_of_doctor" value="<?='Котель' ?>"
                        readonly>
                       
                </div>

                <input type="hidden" name="id_user" value="<?= $id_user ?>">
                <!--Кнопка изменить-->
                <div class="block_info_button">
                    
                    <button type="submit" class="info_submit">Изменить</button>
                    </form>
                    <form action="warrning.php" method="post">
                        <input hidden name="my" value="1">
                        <input hidden name="id_patient" value="<?= $id_patient ?>">
                    <button type="submit" class="info_submit_my">Открепиться от МУ</button>
                    </form>
                    
                </div>
            
            
        </div>




        <div class="talone">
            <span class="info_title">Ваши талоны</span>
            <div class="talone_content">
                <form class="talone_block" action="talone_cout.php" method="post">
                    <div>
                        <span class="speciali_label_talone">Посмотреть предстоящие приемы<span>
                                <input value="<?= $id_user ?>" name="id_user" hidden>
                                <input value="<?=1 ?>" name="yesterday_or_next" hidden>
                    </div>
                    <div>
                        <button type="submit" class="talone_button">Посмотреть</button>
                    </div>
                </form>

                <form class="talone_block" action="talone_cout.php" method="post">
                    <div>
                        <span class="speciali_label_talone">Посмотреть приемы на сегодня<span>
                                <input value="<?= $id_user ?>" name="id_user" hidden>
                                <input value="<?=3 ?>" name="yesterday_or_next" hidden>
                    </div>
                    <div>
                        <button type="submit" class="talone_button">Посмотреть</button>
                    </div>
                </form>

                <form class="talone_block" action="talone_cout.php" method="post">
                    <div>
                        <span class="speciali_label_talone">Посмотреть прошедшие приемы<span>
                                <input value="<?= $id_user ?>" name="id_user" hidden>
                                <input value="<?=2 ?>" name="yesterday_or_next" hidden>

                    </div>
                    <div>
                        <button type="submit" class="talone_button">Посмотреть</button>

                    </div>
                </form>


            </div>
        </div>

        <?php
    if ($check_doctor == null) {
        echo '
            <div class="ecp1">
            <span_ecp class="info_title">Для получения <br> электронной карты пациента, прикрепитесь к врачу.</span>       
            </div>';
    } else {

        echo '
            <div class="ecp1">
            <div>
            <span_ecp class="info_title_ecp">Тут ваша электронная карта пациента</span>
            </div> 
            <div class = "ecp_box">
            <div class = "ecp_mini_box">            
            <span class = "speciali_label_talone">Ваша история приемов</span> 
            <form action = "appointment_cout.php" method = "post"> 
            <input hidden name = "id_patient" value = "' . $id_patient . '">
            <button type = "submit" class="talone_button">Подробнее</button>
            </form>
            </div>
            
            <div class = "ecp_mini_box">            
            <span class = "speciali_label_talone">Ваша история анализов</span>  
            <button class="talone_button">Подробнее</button>
            </div>   

            <div class = "ecp_mini_box">            
            <span class = "speciali_label_talone">Ваша история обследований</span>  
            <button class="talone_button">Подробнее</button>
            </div>
            </div>   
            </div>';

    }
        ?>



    </div>
</body>

<?php
}
?>