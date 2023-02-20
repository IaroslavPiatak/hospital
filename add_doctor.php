<?php
require_once 'connection.php';

$specialization = mysqli_fetch_all(mysqli_query($connect, "SELECT `name_specialization` FROM `specialization`"));
$specialization_count = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `specialization`"));





?>
<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/add_doctor.css" type="text/css"><!--для обнуления-->

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <!--Навигация-->
        <nav class="navbar">

            <a class="navbar_exit" href="lk_admin.php">Вернуться в личный кабинет</a>

        </nav>
        <div class="content">


            <span class="doctor_title">Добавить врача</span>
            <form class="doctor_form" action="uppload/add_doctor.php" method="post">

                <input required class="speciali_input" type="text" name="last_name" placeholder="Введите фамилию доктора">

                <input required class="speciali_input" type="text" name="first_name" placeholder="Введите имя доктора">

                <input required class="speciali_input" type="text" name="patronymic_name" placeholder="Введите отчество доктора">

                <input required class="speciali_input" type="text" name="login" placeholder="Введите логин доктора">

                <input required class="speciali_input" type="text" name="password" placeholder="Введите пароль доктора">


                <select class="month" name='specialization'>
                    <?php
                    for ($i = 0; $i < $specialization_count[0][0]; $i++)
                        echo "<option value=" . $specialization[$i][0] . ">" . $specialization[$i][0] . "</option>";

                    ?>
                </select>

                <select class="month" name='smena'>
                    <option class="month" value='1'>8:00 - 12:00</option>
                    <option value='2'>13:00 - 17:00</option>

                </select>

                <select class="month" name='cabinet'>
                    <?php
                    $cabinet = mysqli_query($connect, "SELECT `id_cabinet`, `name_cabinet` FROM `cabinet`");
                    $cabinet = mysqli_fetch_all($cabinet);
                    $cabinet_count = mysqli_query($connect, "SELECT COUNT(*) FROM `cabinet`");
                    $cabinet_count = mysqli_fetch_all($cabinet_count);
                    for ($i = 0; $i < $cabinet_count[0][0]; $i++)
                        echo "<option value=" . $cabinet[$i][0] . ">" . $cabinet[$i][1] . "</option>";
                    ?>
                </select>
                <br>
                <button class="doctor_submit" type="submit">Добавить врача</button>

            </form>



        </div>





    </div>
    </div>
</body>

</html>