<?php include "../includes/sidebar.php"; ?>

<?php
if ($_SESSION['user_type'] == 'client' || $_SESSION['user_type'] == 'admin') {
    $user_id = $_SESSION['user_id'];

    // Query to count the total facilities created by the logged-in client
    $sql_facilities_count = "SELECT COUNT(*) as total_facilities FROM facility WHERE created_by = ?";
    $stmt_facilities_count = $conn->prepare($sql_facilities_count);
    $stmt_facilities_count->bind_param("i", $user_id);
    $stmt_facilities_count->execute();
    $result_facilities_count = $stmt_facilities_count->get_result();
    $facilities_count = $result_facilities_count->fetch_assoc()['total_facilities'];

    // Query to count the total bookings for facilities created by the logged-in client
    $sql_bookings_count = "
        SELECT COUNT(*) as total_bookings 
        FROM bookings b
        JOIN facility f ON b.event_id = f.id
        WHERE f.created_by = ?";
    $stmt_bookings_count = $conn->prepare($sql_bookings_count);
    $stmt_bookings_count->bind_param("i", $user_id);
    $stmt_bookings_count->execute();
    $result_bookings_count = $stmt_bookings_count->get_result();
    $bookings_count = $result_bookings_count->fetch_assoc()['total_bookings'];

    // Query to count the total users if the logged-in user is an admin
    $user_count = 0;
    if ($_SESSION['user_type'] == 'admin') {
        $sql_user_count = "SELECT COUNT(*) as total_users FROM users WHERE type = 'user'";
        $result_user_count = $conn->query($sql_user_count);
        $user_count = $result_user_count->fetch_assoc()['total_users'];

        // Query to count the total contacts
        $sql_contacts_count = "SELECT COUNT(*) as total_contacts FROM contact";
        $result_contacts_count = $conn->query($sql_contacts_count);
        $contacts_count = $result_contacts_count->fetch_assoc()['total_contacts'];
    }
}
?>

<div class="w3-content dashboard-page">
    <h2>Dashboard</h2>
    <div class="dashboard-stats">
        <?php if ($_SESSION['user_type'] == 'client'): ?>
            <div class="stat-box">
                <h3>Total Facilities</h3>
                <p><?php echo $facilities_count; ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Bookings</h3>
                <p><?php echo $bookings_count; ?></p>
            </div>
        <?php endif; ?>
        <?php if ($_SESSION['user_type'] == 'admin'): ?>
            <div class="stat-box">
                <h3>Total Users</h3>
                <p><?php echo $user_count; ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Contacts</h3>
                <p><?php echo $contacts_count; ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "../includes/footer.php"; ?>

<style>
    .dashboard-page {
        margin-top: 100px;
        text-align: center;
    }

    .dashboard-stats {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }

    .stat-box {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 200px;
    }

    .stat-box h3 {
        margin-bottom: 10px;
        color: #1f1e1e;
    }

    .stat-box p {
        font-size: 24px;
        font-weight: bold;
        color: #1f1e1e;
    }
</style>
