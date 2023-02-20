<?php
require_once "../connection.php";

$id_cabinet = $_POST['cabinet'];
$smena = $_POST['smena'];
$login = $_POST['login'];
$password = $_POST['password'];

$id_user = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_user` FROM `user` WHERE `login` = '$login' AND `password` = '$password'"))[0][0];

mysqli_query($connect, "UPDATE `doctor` SET `cabinet` = '$id_cabinet', `id_smena` = '$smena' WHERE `id_user` = '$id_user'");

/*
 * Переадресация на главную страницу
 */

header('Location: ../lk_doctor.php');
?>