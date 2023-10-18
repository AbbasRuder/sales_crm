<?php
include("config.php");

$clientID = $_POST["client_id"];
$assigned_to = $_POST["assigned_to"];
$status = $_POST["status"];
$response = $_POST["response"];
$remark = $_POST["remark"];

// Update sales_info table
$updateQuery = "UPDATE sales_info SET status = '$status', response = '$response', remark = '$remark' WHERE client_id = '$clientID' AND assigned_to = '$assigned_to'";
$updateResult = $conn->query($updateQuery);

if ($updateResult) {
    echo json_encode(array("success" => true, "message" => "Sales info updated successfully."));
} else {
    echo json_encode(array("success" => false, "message" => "Error updating sales info: " . $conn->error));
}

$conn->close();
?>
