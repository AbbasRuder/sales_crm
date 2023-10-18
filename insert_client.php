<?php
include("config.php");

$name = $_POST['name'];
$sc_name = $_POST['sc_name'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$created_by = $_POST['created_by'];
$assigned_to = $_POST['assigned_to'];


$check = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `client_info` WHERE `email` = '$email' AND `sc_name` = '$sc_name'"));

if($check == 0){
    $sql = mysqli_query($conn, "INSERT INTO `client_info` SET `name` = '$name', `sc_name` = '$sc_name', `email` = '$email', `address` = '$address', `phone` = '$phone'");

    if($sql){
        // Get the id from the latest sql insertion
        $latestRecord = mysqli_insert_id($conn);
        $insert_sale = mysqli_query($conn, "INSERT INTO `sales_info` SET `client_id` = '$latestRecord', `assigned_to` = '$assigned_to', `created_by` = '$created_by'");
        if($insert_sale){
            echo json_encode(array("success" => true, "message" => "Client and Sales Created"));
        }else{
            echo json_encode(array("success" => false, "message" => "Something went wrong"));
        }
    }
}else{
    echo json_encode(array("success" => false, "message" => "Client already exist"));
}
