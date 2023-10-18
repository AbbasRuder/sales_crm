<?php
include("config.php");

// Get POST data
$email = $_POST["email"];
$password = mysqli_real_escape_string($conn, $_POST["password"]);


// Query the database
$sql = "SELECT * FROM users WHERE `email` = '$email' AND BINARY `password` = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $userDetails = $result->fetch_assoc();
    echo json_encode(array("success" => true, "message" => "Login successful.", 'result' => $userDetails ));
} else {
    echo json_encode(array("success" => false, "message" => "Invalid email or password."));
}

$conn->close();
?>
