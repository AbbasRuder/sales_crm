<?php
include("config.php");

$userID = $_POST["id"];

// Query sales_info table to get client IDs associated with the user
$salesQuery = "SELECT DISTINCT client_id FROM sales_info WHERE assigned_to = '$userID'";
$salesResult = $conn->query($salesQuery);

$clientIDs = array();

if ($salesResult->num_rows > 0) {
    while ($row = $salesResult->fetch_assoc()) {
        $clientIDs[] = $row["client_id"];
    }

    $clientIDsString = implode(",", $clientIDs);

    // Query client_info table to get client details
    $clientDetailsQuery = "SELECT * FROM client_info WHERE id IN ($clientIDsString)";
    $clientDetailsResult = $conn->query($clientDetailsQuery);

    $clientDetails = array();

    if ($clientDetailsResult->num_rows > 0) {
        while ($row = $clientDetailsResult->fetch_assoc()) {
            // Retrieve additional columns from sales_info for each client
            $clientID = $row["id"];
            $salesInfoQuery = "SELECT status, response, remark FROM sales_info WHERE client_id = '$clientID' AND assigned_to = '$userID'";
            $salesInfoResult = $conn->query($salesInfoQuery);

            if ($salesInfoResult->num_rows > 0) {
                $salesInfoRow = $salesInfoResult->fetch_assoc();
                $row["status"] = $salesInfoRow["status"];
                // $row["response"] = $salesInfoRow["response"];
                // $row["remark"] = $salesInfoRow["remark"];
            }

            $clientDetails[] = $row;
        }
    }

    echo json_encode(array("success" => true, "client_details" => $clientDetails));
} else {
    echo json_encode(array("success" => false, "message" => "No clients found for the user."));
}

$conn->close();
?>
