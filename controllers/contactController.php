<?php
session_start();
include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contact (subject, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $subject, $email, $message);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Message submitted successfully!";
    } else {
        $_SESSION['error_message'] = "Error: " . $conn->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();

    // Redirect to contact page after handling form submission
    header("Location: ../pages/contact.php");
    exit();
} else {
    // Redirect to contact page if accessed directly without a POST request
    header("Location: ../pages/contact.php");
    exit();
}
?>
