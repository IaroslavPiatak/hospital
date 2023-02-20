<?php
require_once '../connection.php';
$action = $_POST['action'];

if ($action == 'analyz') {
    $id_patient = $_POST['id_patient'];
    $date = $_POST['date'];
    $name_analyz = $_POST['name_analyz'];
    $result_analyz = $_POST['result_analyz'];

    mysqli_query($connect, "INSERT INTO `analyzes` (`id_patient`, `name_analyzes`, `result_analyzes`, `date`) 
VALUES ('$id_patient', '$name_analyz', '$result_analyz', '$date')");
        header('Location: ../lk_doctor.php');


}

else if($action == 'survey')
{
    $id_patient = $_POST['id_patient'];
    $date = $_POST['date'];
    $name_survey = $_POST['name_survey'];
    $result_survey = $_POST['result_survey'];

    mysqli_query($connect, "INSERT INTO `surveys` (`id_patient`, `name_surveys`, `result_surveys`, `date`) 
VALUES ('$id_patient', '$name_survey', '$result_survey', '$date')");
        header('Location: ../lk_doctor.php');

}



else {
    $id_patient = $_POST['id_patient'];
    $id_talone = $_POST['id_talone'];
    $id_doctor = $_POST['id_doctor'];
    $diagnosis = $_POST['diagnosis'];
    $recomendation = $_POST['recomendation'];
    $date = $_POST['date'];

    $check_count = mysqli_fetch_all(mysqli_query($connect, "SELECT COUNT(*) FROM `appointment` WHERE `id_patient` = '$id_patient' AND `id_talone` = '$id_talone' AND `id_doctor` = '$id_doctor'
AND `date` = '$date'"))[0][0];
    if ($check_count > 0)
        echo 'Запись в ЭКП у данного пациента на данный талон уже есть !';
    else {
        mysqli_query($connect, "INSERT INTO `appointment` (`id_patient`, `id_talone`, `diagnosis`, `recomendations`, `id_doctor`, `date`) 
VALUES ('$id_patient', '$id_talone', '$diagnosis', '$recomendation', '$id_doctor', '$date')");
        header('Location: ../lk_doctor.php');

    }



}
?>