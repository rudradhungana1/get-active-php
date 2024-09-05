<?php
session_start();
include "../includes/db.php";

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    $sql = "DELETE FROM client_events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);

    try {
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Event deleted successfully!";
        } else {
            $_SESSION['error_message'] = "Error occurred while deleting the event.";
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['error_message'] = "Error occurred while deleting the event: " ;
    }

    $stmt->close();
} else {
    $_SESSION['error_message'] = "Event ID is not provided.";
}

header("Location: ../pages/events_list.php");
exit();
?>
