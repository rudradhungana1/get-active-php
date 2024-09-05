<?php
session_start();
include "../includes/db.php";

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Check if the user is a member
    $user_id = $_SESSION['user_id'];
    $sql_check_membership = "SELECT is_member FROM users WHERE id = ?";
    $stmt_check_membership = $conn->prepare($sql_check_membership);
    $stmt_check_membership->bind_param("i", $user_id);
    $stmt_check_membership->execute();
    $result_check_membership = $stmt_check_membership->get_result();
    $user = $result_check_membership->fetch_assoc();

    // If the user is not a member, display error message
    if (!$user['is_member']) {
        $_SESSION['error_message'] = "You must become a member to book an event. Go to your profile and become a member.";
        header("Location: ../pages/profile.php");
        exit();
    } else {
        // User is a member, proceed with booking the event
        // Check if the event has more than 0 participants available
        $sql_check_participants = "SELECT max_participants FROM client_events WHERE id = ?";
        $stmt_check_participants = $conn->prepare($sql_check_participants);
        $stmt_check_participants->bind_param("i", $event_id);
        $stmt_check_participants->execute();
        $result_check_participants = $stmt_check_participants->get_result();
        $event = $result_check_participants->fetch_assoc();

        if ($event['max_participants'] <= 0) {
            $_SESSION['error_message'] = "This event cannot be booked as it has no available spots.";
            header("Location: ../pages/view-event.php?id=$event_id");
            exit();
        }

        // Construct the INSERT statement to insert the booking into the bookings table, including booking_date
        $sql_insert_booking = "INSERT INTO bookings (user_id, event_id, booking_date) VALUES (?, ?, NOW())";
        $stmt_insert_booking = $conn->prepare($sql_insert_booking);
        $stmt_insert_booking->bind_param("ii", $user_id, $event_id);

        // Execute the INSERT statement
        if ($stmt_insert_booking->execute()) {
            // Update participants count in the event table
            $sql_update_participants = "UPDATE client_events SET max_participants = max_participants - 1 WHERE id = ?";
            $stmt_update_participants = $conn->prepare($sql_update_participants);
            $stmt_update_participants->bind_param("i", $event_id);
            $stmt_update_participants->execute();

            // Booking and participants update successful
            $_SESSION['success_message'] = "Event booked successfully.";
            header("Location: ../pages/view-event.php?id=$event_id");
            exit();
        } else {
            // Error occurred while inserting the booking
            $_SESSION['error_message'] = "Error booking event: " . $stmt_insert_booking->error;
            header("Location: ../pages/view-event.php?id=$event_id");
            exit();
        }
    }

} else {
    header("Location: facilities.php");
    exit();
}
?>
