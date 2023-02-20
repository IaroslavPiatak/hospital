<?php
session_start();

$text = $_SESSION['warrning']['text'];
$name_button = $_SESSION['warrning']['name_button'];
$link = $_SESSION['warrning']['link'];
$my = $_POST['my'];
$id_patient = $_POST['id_patient'];


if ($my == 1) {
?>
<!DOCTYPE html>
<html>

<head>
    <title>Внимание !</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/warrning.css" type="text/css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <div class="warrning_box">
            <div class="warrning_title">

                <div class="warrning_img">
                    <img class="warrning_img" src="image/warrning.png">
                </div>
                <div class="warrning_title_text">
                    <span>Внимание !</span>
                </div>
            </div>

            <div class="warrnint_text">
                <span>После открепления от муниципального учреждения, вы больше не сможете войти в свой аккаунт !<br>
                    <span>Вы уверены, что хотите открепиться ?</span></span>
            </div>
        </div>
        <div class="buttons">
            <form action="uppload/my_exit.php" method="post">
                <input hidden name="id_patient" value="<?= $id_patient ?>">
                <button type="submit" class="button_my1">Да</button>
            </form>
            <button  class="button_my2" onclick="window.location.href = 'lk_patient.php';" class="button">Нет</button>
        </div>
    </div>

</body>
<?php
} else {
    ?>

<!DOCTYPE html>
<html>

<head>
    <title>Личный кабинет доктора</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css"><!--для обнуления-->
    <link rel="stylesheet" href="css/warrning.css" type="text/css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

</head>

<body>
    <!--Главный контейнер-->
    <div class="container">
        <div class="warrning_box">
            <div class="warrning_title">

                <div class="warrning_img">
                    <img class="warrning_img" src="image/warrning.png">
                </div>
                <div class="warrning_title_text">
                    <span>Внимание !</span>
                </div>
            </div>

            <div class="warrnint_text">
                <span>
                    <?= $text ?>
                </span>
            </div>
        </div>

        <button onclick="window.location.href = '<?= $link ?>';" class="button">
            <?= $name_button ?>
        </button>
    </div>

</body>
<?php

}

?>