<?php
session_start();
if($_SESSION['user_autorization'])
header('Location: ../lk_patient.php');

require_once "../connection.php";

$login = $_POST['login'];
$password = $_POST['password'];
$role = mysqli_fetch_all(mysqli_query($connect, "SELECT `role` FROM `user` WHERE `login` = '$login' AND `password` = '$password'"))[0][0];

$_SESSION['user_autorization'] =
    [
        'login' => $login,
        'password' => $password,
        'role' => $role
    ];


$check_users = mysqli_query($connect, "SELECT * FROM `user` WHERE `login` = '$login' AND `password` = '$password'"); // есть ли такой юзер


$check_role = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `role` FROM `user` WHERE `login` = '$login' AND `password` = '$password'")); // какая у него роль
$unit = $check_role['role'];

$user_id  = mysqli_query($connect, "SELECT `id_user` FROM `user` WHERE `login` = '$login' AND `password` = '$password'");
$user_id = mysqli_fetch_all($user_id);
$user_id = $user_id[0][0];

$check_status = mysqli_query($connect, "SELECT `status` FROM `patient` WHERE `user_id` = '$user_id'");
$check_status = mysqli_fetch_all($check_status);
$check_status = $check_status[0][0];











if (mysqli_num_rows($check_users) > 0) {

    if ($unit == 1)
        header('Location: ../lk_admin.php');
    else if ($unit == 2)
        header('Location: ../lk_doctor.php');
    else if ($unit == 3)
        if ($check_status == 1) 
        {
            $_SESSION['warrning'] =
        [
            'text' => 'Для входа в личный кабинет после регистрации, необходимо подтверждение вашего аккаунта администратором.
             Обычно, данная процедура занимает не более 5 минут',
            'link' => 'autorization.php',
            'name_button' => 'Хорошо'
        ];
        
    
        $_SESSION['user_autorization'] = array();
        unset($_SESSION['user_autorization']);
        header('Location: ../warrning.php');
        }

        else if ($check_status == 2 ) 
        {
            $_SESSION['warrning'] =
        [
            'text' => 'Ваш аккаунт заблокирован, обратитесь к администратору для разблокировки',
            'link' => 'autorization.php',
            'name_button' => 'Хорошо'
        ];
        
    
        $_SESSION['user_autorization'] = array();
        unset($_SESSION['user_autorization']);
        header('Location: ../warrning.php');
        }

        else if ( $check_status == 3) 
        {
            $_SESSION['warrning'] =
        [
            'text' => 'Ваш аккаунт был удален, так как вы открепились от своего муниципального учреждения',
            'link' => 'autorization.php',
            'name_button' => 'Печально :('
        ];
        
    
        $_SESSION['user_autorization'] = array();
        unset($_SESSION['user_autorization']);
        header('Location: ../warrning.php');
        }




        else
        header('Location: ../lk_patient.php');
    else
        echo "<strong>Непредвиденная ошибка, сообщите о ней администратору</strong>";
}
   
  
    
else{

    $_SESSION['warrning'] =
        [
            'text' => 'Такого аккаунта не существует ! Хотите зарегистрироваться ?',
            'link' => 'reg1.php',
            'name_button' => 'Зарегистрироваться'
        ];
    
    $_SESSION['user_autorization'] = array();
    unset($_SESSION['user_autorization']);
    header('Location: ../warrning.php');

}



