<?php
session_start();
include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $facility_id = $_POST['facility_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $distance = $_POST['distance'];

    // Check if the user is the creator of the facility
    $sql_check_creator = "SELECT created_by FROM facility WHERE id = ?";
    $stmt_check_creator = $conn->prepare($sql_check_creator);
    $stmt_check_creator->bind_param("i", $facility_id);
    $stmt_check_creator->execute();
    $result_check_creator = $stmt_check_creator->get_result();

    if ($result_check_creator->num_rows == 0 || $result_check_creator->fetch_assoc()['created_by'] != $_SESSION['user_id']) {
        $_SESSION['error_message'] = "You don't have permission to edit this facility.";
        header("Location: ../pages/facilities_list.php");
        exit();
    }

    // Handle image upload
    if ($_FILES['new_image']['name']) {
        $image = base64_encode(file_get_contents($_FILES['new_image']['tmp_name']));
    } else {
        $sql_image = "SELECT image FROM facility WHERE id = ?";
        $stmt_image = $conn->prepare($sql_image);
        $stmt_image->bind_param("i", $facility_id);
        $stmt_image->execute();
        $result_image = $stmt_image->get_result();

        if ($result_image->num_rows == 1) {
            $facility = $result_image->fetch_assoc();
            $image = $facility['image'];
        } else {
            $_SESSION['error_message'] = "Facility not found.";
            header("Location: ../pages/facilities_list.php");
            exit();
        }
    }

    // Update facility in the database
    $sql = "UPDATE facility SET title=?, description=?, category=?, distance=?, image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisi", $title, $description, $category, $distance, $image, $facility_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Facility updated successfully.";
        header("Location: ../pages/facilities_list.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
        exit();
    }

    $stmt->close();
} else {
    header("Location: ../pages/facilities_list.php");
    exit();
}
?>
