<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "salescrm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$email = $_POST["email"];
$password = $_POST["password"];


// Query the database
$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode(array("success" => true, "message" => "Login successful.", "email" => $email, "password" => $password ));
} else {
    echo json_encode(array("success" => false, "message" => "Invalid email or password.", "email" => $email, "password" => $password ));
}

$conn->close();
?>
