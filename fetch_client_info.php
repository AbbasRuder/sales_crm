<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "salescrm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_POST["id"];

$salesQuery = "SELECT DISTINCT client_id FROM sales_info WHERE assigned_to = '$userID'";
$salesResult = $conn->query($salesQuery);

$clientIDs = array();

if ($salesResult->num_rows > 0) {
    while ($row = $salesResult->fetch_assoc()) {
        $clientIDs[] = $row["client_id"];
    }

    $clientIDsString = implode(",", $clientIDs);
    $clientDetailsQuery = "SELECT * FROM client_info WHERE id IN ($clientIDsString)";
    $clientDetailsResult = $conn->query($clientDetailsQuery);

    $clientDetails = array();

    if ($clientDetailsResult->num_rows > 0) {
        while ($row = $clientDetailsResult->fetch_assoc()) {
            $clientDetails[] = $row;
        }
    }

    echo json_encode(array("success" => true, "client_details" => $clientDetails));
} else {
    echo json_encode(array("success" => false, "message" => "No clients found for the user."));
}

$conn->close();
?>
