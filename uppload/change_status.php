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

$id = $_POST['id_user'];
$login = $_POST['login'];
$password = $_POST['password'];

$_SESSION['user_autorization']['login'] = $login;
$_SESSION['user_autorization']['password'] = $password;


/*
 * Делаем запрос на изменение строки в таблице products
 */

mysqli_query($connect, "UPDATE `user` SET `login` = '$login', `password` = '$password'  WHERE `id_user` = '$id'");

/*
 * Переадресация на главную страницу
 */

header('Location: ../lk_patient.php');