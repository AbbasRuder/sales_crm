<?php
include("config.php");
$assignedTo = $_POST["assigned_to"]; 
$clientID = $_POST["client_id"];

// Query client_info table to get basic client details
$clientDetailsQuery = "SELECT * FROM client_info WHERE id = '$clientID'";
$clientDetailsResult = $conn->query($clientDetailsQuery);

$clientDetails = array();

if ($clientDetailsResult->num_rows > 0) {
    $row = $clientDetailsResult->fetch_assoc();

    // Query sales_info table to get additional columns
    $salesInfoQuery = "SELECT status, response, remark FROM sales_info WHERE client_id = '$clientID' AND assigned_to = '$assignedTo'";
    $salesInfoResult = $conn->query($salesInfoQuery);

    if ($salesInfoResult->num_rows > 0) {
        $salesInfoRow = $salesInfoResult->fetch_assoc();
        $row["status"] = $salesInfoRow["status"];
        $row["response"] = $salesInfoRow["response"];
        $row["remark"] = $salesInfoRow["remark"];
    }

    $clientDetails[] = $row;

    echo json_encode(array("success" => true, "client_details" => $clientDetails));
} else {
    echo json_encode(array("success" => false, "message" => "No client found with the provided ID."));
}

$conn->close();
?>
