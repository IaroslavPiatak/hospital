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



$id_status = $_POST['status'];
$id = $_POST['id_user'];
$login = $_POST['login'];
$password = $_POST['password'];






/*
 * Делаем запрос на изменение строки в таблице products
 */

mysqli_query($connect, "UPDATE `user` SET `login` = '$login', `password` = '$password'  WHERE `id_user` = '$id'");
mysqli_query($connect, "UPDATE `patient` SET `status` = '$id_status'   WHERE `user_id` = '$id'");

header('Location: ../lk_admin.php');


/*
 * Переадресация на главную страницу
 */

