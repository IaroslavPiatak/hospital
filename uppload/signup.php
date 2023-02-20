<?php
session_start();
if ($_SESSION['user_autorization'])
    header('Location: ../lk_patient.php');

require_once '../connection.php';
$last_name = $_POST['last_name'];
$first_name = $_POST['first_name'];
$patronymic_name = $_POST['patronymic_name'];
$date_of_birthday = $_POST['date_of_birthday'];
$mip_number = $_POST['mip_number'];
$check_user = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `patient`
WHERE `last_name` = '$last_name' AND `first_name` = '$first_name' AND `patronymic_name` = '$patronymic_name' AND `date_of_birthday` = '$date_of_birthday'"))[0][0];
$_SESSION['user'] =
    [
        'last_name' => $last_name,
        'first_name' => $first_name,
        'patronymic_name' => $patronymic_name,
        'date_of_birthday' => $date_of_birthday,
        'mip_number' => $mip_number
    ];

$check_mip_number = mysqli_query($connect, "SELECT * FROM `patient` WHERE `mip_number` = '$mip_number'"); // проверка СМП на уникальность
if (mysqli_num_rows($check_mip_number) > 0) {


    $_SESSION['warrning'] =
        [
            'text' => 'Пользователь с таким номером СМП уже существует !',
            'link' => 'reg1.php',
            'name_button' => 'Вернуться назад'
        ];

    $_SESSION['user_autorization'] = array();
    unset($_SESSION['user_autorization']);
    header('Location: ../warrning.php');




} 
else if (strstr($date_of_birthday, '-', true) < 1900 || strstr($date_of_birthday, '-', true) > getdate()['year']) {
    $_SESSION['warrning'] =
        [
            'text' => 'Дата рождения введина не корректно !',
            'link' => 'reg1.php',
            'name_button' => 'Исправить'
        ];

    $_SESSION['user_autorization'] = array();
    unset($_SESSION['user_autorization']);
    header('Location: ../warrning.php');

}

else if ($check_user > 0)
{
    $_SESSION['warrning'] =
    [
        'text' => 'Пользователь с таким ФИО и датой рождения уже зарегистрирован !',
        'link' => 'autorization.php',
        'name_button' => 'Авторизироваться'
    ];

$_SESSION['user_autorization'] = array();
unset($_SESSION['user_autorization']);
header('Location: ../warrning.php');
}
else {


    //print_r(strstr($date_of_birthday, '-', true)); зачем это тут ??? 
    header('Location: ../reg2.php');


}
?>