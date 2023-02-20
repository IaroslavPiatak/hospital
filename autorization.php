<?php

session_start();

if($_SESSION['user_autorization'])
header('Location: lk_patient.php');





?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Авторизация</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
    </head>
    <body>
        <!--основная формочка регистрации-->
      
     
        
        <form class="forms" action = "uppload/signin.php" method = "post"> 
            <p class="p1">Авторизация</p>
          
            <input type="login" class="log" name="login" placeholder="Логин"  maxlength="25" required >
            <input type="password" class="pas" name="password" maxlength="25" placeholder="Пароль" required > 
             <input type="submit" class="enter" value="Войти">
             <a href ="reg1.php" class="sil">Зарегистрироваться</a>
        
             <a href ="help_of_password.html" class="lis">Забыли пароль ?</a>
    </form>
           
            

        </div>
    </body>
</html>
