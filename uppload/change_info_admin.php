<?php
session_start();


//Обновление информации о продукте

/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */

require_once '../connection.php';

/*
 * Создаем переменные со значениями, которые были получены с $_POST
 */

$mip_number = $_POST['mip_number'];
$phone_number = $_POST['phone_number'];
$passport = $_POST['passport'];
$address = $_POST['address'];
$id_user = $_POST['id_user'];
$id_doctor = $_POST['doctor_id'];


/*
 * Делаем запрос на изменение строки в таблице products
 */

mysqli_query($connect, "UPDATE `patient` SET `mip_number` = '$mip_number', `id_doctor` = '$id_doctor', `phone_number` = '$phone_number', `passport` = '$passport', `address` = '$address' WHERE `user_id` = '$id_user'");

/*
 * Переадресация на главную страницу
 */

header('Location: ../lk_admin.php');