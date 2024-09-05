<?php
session_start(); // Start the session
include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $distance = $_POST['distance'];

    $image_base64 = '';
    if ($_FILES['image']['error'] === 0) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_data = file_get_contents($image_tmp);
        $image_base64 = base64_encode($image_data);
    } else {
        $_SESSION['error_message'] = "Image upload failed.";
        header("Location: ../pages/add-facilities.php");
        exit();
    }

    $created_by = $_SESSION['user_id'];

    $sql = "INSERT INTO facility (title, description, created_by, image, category, distance) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $title, $description, $created_by, $image_base64, $category, $distance);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Facility added successfully!";
        header("Location: ../pages/add-facilities.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $conn->error;
        header("Location: ../pages/add-facilities.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../pages/add-facilities.php");
    exit();
}
?>
