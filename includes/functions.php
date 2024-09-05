<?php

function redirect($url) {
    header("Location: $url");
    exit();
}



function getUserInfo($user_id)
{
    global $conn;

    // Prepare and execute SQL statement to retrieve user information
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        // Fetch user details
        $user_info = $result->fetch_assoc();
        return $user_info;
    } else {
        // User not found
        return null;
    }
}