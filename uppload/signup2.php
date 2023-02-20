<?php
session_start();
require_once '../connection.php';
if($_SESSION['user_autorization'])
header('Location: ../lk_patient.php');
$login = $_POST['login'];
$password = $_POST['password'];
$password_repiad = $_POST['password_repiad'];


$first_name = $_SESSION['user']['first_name'];
$last_name =  $_SESSION['user']['last_name']; 
$patronymic_name = $_SESSION['user']['patronymic_name'];
$date_of_birthday =  $_SESSION['user']['date_of_birthday'];
$mip_number = $_SESSION['user']['mip_number'];





$check_login = mysqli_query($connect, "SELECT * FROM `user` WHERE `login` = '$login'");


if($password !== $password_repiad)
{
    $_SESSION['warrning'] =
    [
        'text' => 'Пароли на совпадают !',
        'link' => 'reg2.php',
        'name_button' => 'Исправить'
    ];

$_SESSION['user_autorization'] = array();
unset($_SESSION['user_autorization']);
header('Location: ../warrning.php');

}

else if(mysqli_num_rows($check_login) > 0){

   
    $_SESSION['warrning'] =
    [
        'text' => 'Этот логин уже занят !',
        'link' => 'reg2.php',
        'name_button' => 'Исправить'
    ];

$_SESSION['user_autorization'] = array();
unset($_SESSION['user_autorization']);
header('Location: ../warrning.php');
    

}
else{
    mysqli_query($connect, "INSERT INTO `user` (`id_user`, `login`, `password`, `role`) VALUES (NULL, '$login', '$password', '3')");
    $check_user_id = mysqli_query($connect, "SELECT * FROM `user`");
    $check_user_id = mysqli_fetch_all($check_user_id);
    foreach($check_user_id as $check_user_id)
    {
        $user_id = $check_user_id[0];
      
       
    }
    
    mysqli_query($connect, "INSERT INTO `patient` (`first_name`, `last_name`, `patronymic_name`, `date_of_birthday`, `mip_number`, `status`, `user_id`) VALUES ('$first_name', '$last_name', '$patronymic_name', '$date_of_birthday'  , '$mip_number', '1', '$user_id')");

  
    
    $_SESSION['user'] = array();

    header('Location: ../autorization.php');
   

}




?>


