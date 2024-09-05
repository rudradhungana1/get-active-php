<?php
include "../includes/db.php";

$username = 'admin';
$password = 'Admin123';
$email = 'admin@yopmail.com';
$address = 'test';
$user_type = 'admin';
$is_member = 1;

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, email, address, type, is_member) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sssssi", $username, $hashedPassword, $email, $address, $user_type, $is_member);

if ($stmt->execute()) {
    echo "Admin user created successfully.";
} else {
    echo "Error creating admin user: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
