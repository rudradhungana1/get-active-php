<?php
session_start(); // Start the session
include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $event_description = $_POST['event_description'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $max_participants = $_POST['max_participants'];
    $facility_id = $_POST['facility_id'];

    // Convert the image to a Base64 string
    $image_base64 = '';
    if ($_FILES['image']['error'] === 0) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_data = file_get_contents($image_tmp);
        $image_base64 = base64_encode($image_data);
    } else {
        $_SESSION['error_message'] = "Image upload failed.";
        header("Location: ../pages/add-events.php");
        exit();
    }

    // Get the user ID from the session
    $created_by = $_SESSION['user_id'];

    // Insert the client event into the database
    $sql = "INSERT INTO client_events (event_name, event_description, event_date, location, max_participants, facility_id, created_by, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiiss", $event_name, $event_description, $event_date, $location, $max_participants, $facility_id, $created_by, $image_base64);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Event added successfully!";
        header("Location: ../pages/add-events.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $conn->error;
        header("Location: ../pages/add-events.php");
        exit();
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the add client event page if accessed directly without a POST request
    header("Location: ../pages/add-events.php");
    exit();
}
?>
