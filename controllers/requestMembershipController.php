<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in to request membership.";
    header("Location: ./pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO membership_requests (user_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Membership request submitted successfully.";
    } else {
        $_SESSION['error_message'] = "Error submitting membership request.";
    }

    $stmt->close();
    $conn->close();

    header("Location: ../pages/profile.php");
    exit();
} else {
    header("Location: ../pages/profile.php");
    exit();
}
?>
