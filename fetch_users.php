<?php
include('./config.php');

$sql = "SELECT id, name FROM users";
$user_result = $conn->query($sql);

if ($user_result->num_rows > 0) {
    $users = array(); // Initialize an empty array to hold user data
    
    while ($row = $user_result->fetch_assoc()) {
        // Fetch each user's data and add it to the array
        $users[] = $row;
    }
    echo json_encode(array("success" => true, "users" => $users));
} else {
    echo json_encode(array("success" => false, "message" => "No users exists." ));
}

?>