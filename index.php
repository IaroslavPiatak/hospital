<?php
session_start(); // подключаем сессии
$_SESSION['talone'] = array(); // если до этого, пациент уже записывался на прием, то чистим предыдущие данные (возможно, можно и без этой строчки обойтись)

require_once 'connection.php'; // подключаем страницу с подключением к БД
$this_month_number = getdate()['mon']; // узнаем порядковый номер нынешнего месяца

// блок с определением этого и следующего месяца
switch ($this_month_number) { 
    case 1:
        $this_month = 'Январь';
        $next_month = 'Февраль';
        $next_month_number = 2;
        break;
    case 2:
        $this_month = 'Февраль';
        $next_month = 'Март';
        $next_month_number = 3;
        break;
    case 3:
        $this_month = 'Март';
        $next_month = 'Апрель';
        $next_month_number = 4;
        break;
    case 4:
        $this_month = 'Апрель';
        $next_month = 'Май';
        $next_month_number = 5;
        break;
    case 5:
        $this_month = 'Май';
        $next_month = 'Июнь';
        $next_month_number = 6;
        break;
    case 6:
        $this_month = 'Июнь';
        $next_month = 'Июль';
        $next_month_number = 7;
        break;
    case 7:
        $this_month = 'Июль';
        $next_month = 'Август';
        $next_month_number = 8;
        break;
    case 8:
        $this_month = 'Август';
        $next_month = 'Сентябрь';
        $next_month_number = 9;
        break;
    case 9:
        $this_month = 'Сентябрь';
        $next_month = 'Октябрь';
        $next_month_number = 10;
        break;
    case 10:
        $this_month = 'Октябрь';
        $next_month = 'Ноябрь';
        $next_month_number = 11;
        break;
    case 11:
        $this_month = 'Ноябрь';
        $next_month = 'Декабрь';
        $next_month_number = 12;
        break;
    case 12:
        $this_month = 'Декабрь';
        $next_month = 'Январь';
        $next_month_number = 1;
        break;
}

if($this_month == 'Декабрь') // если это последний мясяц в году, то след.год. + 1
{
    $this_year = date('Y');
    $next_year = date('Y') + 1;
}

else // иначе след.год == этому году
{
    $this_year = date('Y');
    $next_year = date('Y');
}
// получаем кол-во специализаций
$specialization_count = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `specialization`"));
// получаем список всех специализаций
$specialization = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM `specialization`"));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Главная</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/index.css" type="text/css">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!--шрифт, подключение-->
        <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
	<meta name="viewport" content = "width=device-width">
    </head>

    <body>
        <div class="container"> <!--Главный контейнер-->
            <nav class="navbar"> <!--Навигационное меню-->
                <a href="#calendar">Запись на прием</a>
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

            <div id='calendar' class="calendar"> <!--Блок календаря-->
                <form name='calendar' action="calendar.php" method="post"> <!--Форма календаря-->
                    <p>Календарь записи к врачу</p>
                    <div class="choice"> <!--контейнер со списками-->
                        <select class="month" name='month'> <!--Один вид для всех списков-->

                            <option value="<?=$this_year . ' ' .$this_month_number ?>">
                                <?= $this_month ?>
                            </option>

                            <option value="<?=$next_year . ' ' .$next_month_number ?>">
                                <?= $next_month ?>
                            
                            </option>
                        </select>

                        <select class="month" name='specialization'>
                            <?php
                            for ($i = 0; $i < $specialization_count[0][0]; $i++)
                            echo "<option value=".$specialization[$i][0].">" . $specialization[$i][1] . "</option>";
                            ?>
                        </select>

                        <select class="month" name='time'>
                            <option value='1'>8:00 - 12:00</option>
                            <option value='2'>13:00 - 17:00</option>

                        </select>
                    </div>
                 
                    <!--Блок с числами-->
                    <div class="number">
                        <?php
                    
                        $day_in_month = cal_days_in_month(CAL_GREGORIAN, $this_month_number, getdate()['year']); // узнаем кол-во дней в месяце
                        for ($i = 1; $i <= $day_in_month; $i++) {
                        ?>
                        <div class="form_radio_btn">
                            <?php
                            if($i <= (getdate()['mday']) ) // делаем число недоступным для выбора , если оно уже прошло и применяем доп.стили
                            {
                                ?>
                                    <input disabled  id="radio<?= $i ?>" type="radio" name="date" value="<?= $i ?>">
                                    <label for="radio<?= $i ?>" style="background-color: #EB5569; color: black; box-shadow: none;">
                                        <?= $i ?>
                                    </label>
                                <?php
                            }
                            else // иначе выводим число
                            {
                                ?>
                                    <input required id="radio<?= $i ?>" type="radio" name="date" value="<?= $i ?>">
                                    <label for="radio<?= $i ?>">
                                        <?= $i ?>
                                    </label>
                                    <?php
                            }
                                    ?>
                        </div>
                        <?php
                        }
                        ?>
                        <?php
                    if(isset($_SESSION['user_autorization'])) // если пользователь авторизировался, то отправляем форму и переходим дальше 
                        echo'<button type="submit" class="sybmit">Следующий шаг</input>';
                    else // иначе отправляем его на страницу авторизации
                        echo'<a href = "autorization.php"><button class="sybmit">Следующий шаг</input></a>'
                        ?>
                    </div>
                </form>
            </div>
        </div>

        <!--Подвал-->
        <footer id='footer'>
            <div class="contac">Сайт сделан командой "ШПКЛ"</p>
                <div class="contact">
                    <p>Контакты для связи:<br> Email: slavik.ipp@gmail.com <br> Telegram: Iaroslav_AP <br> 2022</p>
                </div>
        </footer>
    </body>
</html>