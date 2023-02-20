<?php
// подключение к базе данных, в переменную конект передаем функции, с (адрес, логин базы, пароль, название базы)

    $connect = mysqli_connect('localhost', 'root','','policlinica'); // до этого было root root
    if (!$connect){
        die('Error connect to DataBase'); // если не получится подключится , процесс умерает и выводит сообщение
    }
