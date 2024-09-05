<?php
session_start(); // Start the session
include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['type'];

            if ($user['type'] !== 'user') {
                header("Location: ../pages/dashboard.php");
            } else {
                header("Location: ../pages/index.php");
            }
            exit();
        } else {
            $_SESSION['error_message'] = "Incorrect password. Please try again.";
            header("Location: ../pages/login.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "User not found. Please try again.";
        header("Location: ../pages/login.php");
        exit();
    }
} else {
    header("Location: ../pages/login.php");
    exit();
}
?>
