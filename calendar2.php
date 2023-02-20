<?php
session_start();
$_SESSION['talone']['doctor_name'] = $_POST['doctor_name'];




require_once 'connection.php';

if($_SESSION['talone']['smena'] == 1)
{
    $i = 8;
    $end = 12;
}

else
{
    $i = 13;
    $end = 16;
}
// получаем кол-во специализаций
$specialization_count = mysqli_query($connect, "SELECT COUNT(*) FROM `specialization`");
$specialization_count = mysqli_fetch_all($specialization_count);
// получаем массивы со специализациями
$specialization = mysqli_query($connect, "SELECT * FROM `specialization`");
$specialization = mysqli_fetch_all($specialization);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Главная</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/calendar2.css" type="text/css"> <!--для обнуления-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container"> <!--Главный контейнер-->
    <nav class="navbar"> <!--Навигация-->
            <a href=" index.php #calendar">Запись на прием</a>
            <a href="#" download="document/Руководство_пользователя.docx">Руководство пользователя</a>
            <a href="#footer">Контакты</a>
            <a href="autorization.php">Личный кабинет</a>
        </nav>
        <div class="header"> <!--Шапка сайта-->
            <div class="text"> <!--Для лозунга-->
                <h1>Запишитесь на прием!</h1>
                <h2>Будьте здоровы!</h2>
            </div>
        </div>

        <div class="calendar"> <!--Для лозунга-->
            <form name='calendar' action="talone.php" method="post"> <!--Блок выбора-->
                <p>Выберите время</p>

                <div class="number">
                    <?php
                    
                 $count = 0;    
                   for ($i; $i <= $end; $i++) {
                        for ($j = 0; $j < 60; $j = $j + 15, $count++)
                        if($j == 0)
                        {
                            echo ' <div class="form_radio_btn"">
                            <input id="'.$count.'" type="radio" name="date" value="'.$i. ':'. '00'.'">
                            <label for="'.$count.'">'.$i. ':'."00".'</label>
                            </div>';

                        } else {
                                echo ' <div class="form_radio_btn"">
                            <input id="' . $count . '" type="radio" name="date" value="' . $i . ':' . $j . '">
                            <label for="' . $count . '">' . $i . ':' . $j . '</label>
                            </div>';
                            }
                         
                   }
                   ?>
                </div>
                <!---->
                <div class="buttons">
                    <div>
                    <a href="index.php"><button class="sybmit1">Предыдущий шаг</input></a>
                    </div>
                    <div>
                    <button type="submit" class="sybmit">Следующий шаг</input>
                    </div>
                </div>
            </form>
        </div>
        <!---->
    </div>
    <!---->
    <!--Подвал-->
    <footer>
    <footer id='footer'>
        <div class="contac">Сайт сделан ПАО "ШПКЛ"</p>
            <div class="contact">
                <p>Контакты для связи:<br> Email: slavik.ipp@gmail.com <br> Telegram: Iaroslav_AP <br> 2022</p>
            </div>
    </footer>
    <!---->
</body>