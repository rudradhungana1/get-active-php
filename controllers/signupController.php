<?php
session_start(); // Start the session
include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username already exists
    $check_username_sql = "SELECT id FROM users WHERE username = ?";
    $check_username_stmt = $conn->prepare($check_username_sql);
    $check_username_stmt->bind_param("s", $username);
    $check_username_stmt->execute();
    $check_username_stmt->store_result();
    if ($check_username_stmt->num_rows > 0) {
        // Username already exists, set error message and redirect
        $_SESSION['error_message'] = "Username already exists.";
        header("Location: ../pages/login.php");
        exit();
    }
    $check_username_stmt->close();

    // Check if email already exists
    $check_email_sql = "SELECT id FROM users WHERE email = ?";
    $check_email_stmt = $conn->prepare($check_email_sql);
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $check_email_stmt->store_result();
    if ($check_email_stmt->num_rows > 0) {
        // Email already exists, set error message and redirect
        $_SESSION['error_message'] = "Email already exists.";
        header("Location: ../pages/login.php");
        exit();
    }
    $check_email_stmt->close();

    // Insert user into the database
    $insert_sql = "INSERT INTO users (username, address, email, type, password) VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("sssss", $username, $address, $email, $type, $password);
    if ($insert_stmt->execute()) {
        // Registration successful, set success message and redirect to login page
        $_SESSION['success_message'] = "Registration successful! Please log in.";
        header("Location: ../pages/login.php");
        exit();
    } else {
        // Error inserting user, display error message
        $_SESSION['error_message'] = "Error registering user: " . $insert_stmt->error;
        header("Location: ../pages/register.php");
        exit();
    }
    $insert_stmt->close();
}

$conn->close();
?>
