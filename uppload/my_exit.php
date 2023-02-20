<?
session_start();
require_once "../connection.php";
$id_patient = $_POST['id_patient'];
$date = getdate()['year'] . '-' . getdate()['mon'] . '-' . getdate()['mday'];   


mysqli_query($connect, "UPDATE `patient` SET `status`= '3' WHERE `id_patient` = '$id_patient'");
mysqli_query($connect, "DELETE FROM `talone` WHERE `id_patient` = '$id_patient' AND `date` >= '$date'");
$_SESSION['user'] = array();
$_SESSION['user_autorization'] = array();
session_destroy();
header("Location: ../autorization.php");