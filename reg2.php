<?php
session_start();
if($_SESSION['user_autorization'])
header('Location: lk_patient.php');

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/reg1.css" type="text/css" />
</head>

<body>
    

    

    <form class="forms" action='uppload/signup2.php' method="post">
        <p class="p1">Регистрация</p>
        <input type="login" class="log" name="login" placeholder="Придумайте ваш Логин" required>
        <!--форма логина-->
        <input type="password" class="pas" name="password" placeholder="Придумайте Пароль" required>
        <!--форма пароля-->
        <input type="password" class="pas1" name="password_repiad" placeholder="Повторите Пароль" required>
        <!--форма повторите пароль-->
        <!--кнопки перехода-->
        <button type = "button" onclick="window.location.href = '../reg1.php';" class ="btn">Предыдущий шаг</button>
        <button type = "submit" class ="button">Зарегистрироваться</button>

        
       

    </form>



    <!---->
    </div>
</body>

</html>