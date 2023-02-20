<?php
session_start();
$_SESSION['user'] = array();
$_SESSION['user_autorization'] = array();
session_destroy();
header('Location: ../index.php');