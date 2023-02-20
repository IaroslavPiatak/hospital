<?php
session_start();
require_once '../connection.php';
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$patronymic_name = $_POST['patronymic_name'];
$specialization = $_POST['specialization'];
$smena = $_POST['smena'];
$cabinet = $_POST['cabinet'];
$login = $_POST['login'];

$check_login = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `user` 
WHERE `login` = '$login'"))[0][0];
if ($check_login > 0)
    echo 'Этот логин уже занят !';
else {
    $password = $_POST['password'];
    $id_specialization = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_specialization` FROM `specialization` 
    WHERE `name_specialization` = '$specialization'"))[0][0];


    $check_doctor = mysqli_query($connect, "SELECT COUNT(*) FROM `doctor` WHERE `cabinet` = '$cabinet' AND `id_smena` = '$smena'");
    $check_doctor = mysqli_fetch_all($check_doctor);
    $check_doctor = $check_doctor[0][0];

    if (($check_doctor) > 0) {
        $_SESSION['warrning'] =
        [
            'text' => 'Выбранный кабинет в данную смену уже занят !',
            'link' => 'add_doctor.php',
            'name_button' => 'Вернуться назад'
        ];

    header('Location: ../warrning.php');
    } else {
        mysqli_query($connect, "INSERT INTO `user` (`login`, `password`, `role`) VALUES ( '$login', '$password', '2')");
        $id_user = mysqli_query($connect, "SELECT `id_user` FROM `user` WHERE `login` = '$login' AND `password` = '$password'");
        $id_user = mysqli_fetch_all($id_user);
        $id_user = $id_user[0][0];

        mysqli_query($connect, "INSERT INTO `doctor` (`id_user`, `first_name`, `last_name`, `patronymic_name`, `id_specialization`,`id_smena`, `cabinet`) VALUES ('$id_user', '$first_name', '$last_name', '$patronymic_name', '$id_specialization', '$smena', '$cabinet')");
        header('Location: ../lk_admin.php');

    }

}



?>