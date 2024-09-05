<?php
include "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted with a valid request_id
    if (isset($_POST["request_id"]) && !empty($_POST["request_id"])) {
        $request_id = $_POST["request_id"];

        // Check if the approve button was clicked
        if (isset($_POST["approve"])) {
            // Update the membership request status to approved
            $update_sql = "UPDATE membership_requests SET status = 'approved' WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $request_id);

            if ($update_stmt->execute()) {
                // Update the user's is_member flag to true
                $user_id_sql = "SELECT user_id FROM membership_requests WHERE id = ?";
                $user_id_stmt = $conn->prepare($user_id_sql);
                $user_id_stmt->bind_param("i", $request_id);
                $user_id_stmt->execute();
                $user_id_result = $user_id_stmt->get_result();
                $user_id_row = $user_id_result->fetch_assoc();
                $user_id = $user_id_row["user_id"];

                $update_user_sql = "UPDATE users SET is_member = 1 WHERE id = ?";
                $update_user_stmt = $conn->prepare($update_user_sql);
                $update_user_stmt->bind_param("i", $user_id);

                if ($update_user_stmt->execute()) {
                    $_SESSION['success_message'] = "Membership request approved successfully.";

                } else {
                    $_SESSION['error_message'] = "Error updating user's membership status: " . $update_user_stmt->error;
                }
            } else {
                $_SESSION['error_message'] = "Error approving membership request: " . $update_stmt->error;

            }
        }

        // Check if the reject button was clicked
        if (isset($_POST["reject"])) {
            // Update the membership request status to rejected
            $update_sql = "UPDATE membership_requests SET status = 'rejected' WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $request_id);

            if ($update_stmt->execute()) {
                $_SESSION['success_message'] = "Membership request rejected successfully.";
            } else {
                $_SESSION['error_message'] = "Error rejecting membership request: " . $update_stmt->error;
            }
        }
    } else {
        $_SESSION['error_message'] = "Invalid request.";
    }
} else {
    $_SESSION['error_message'] = "Invalid request method.";
}

header("Location: ../pages/membership_request_list.php");
exit();
?>
