<?php
include "../includes/sidebar.php";
?>

<style>
    .container {
        margin-top: 100px;
        max-width: 800px;
    }

    .w3-table {
        width: 100%;
        border-collapse: collapse;
    }

    .w3-table th,
    .w3-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #2a2929;
    }

    .w3-table th {
        background-color: #605f5f;
    }

    .w3-table img {
        max-width: 100px;
        height: auto;
        border-radius: 8px;
    }

    .w3-center {
        text-align: center;
    }

    .w3-striped tbody tr:nth-child(even) {
        background-color: #f1f1f1;
        color: black;
    }
    .view-participants-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .view-participants-btn:hover {
        background-color: #45a049;
    }

</style>

<?php if ($_SESSION['user_type'] == 'client'): ?>

<div class="w3-content container">
    <h2 class="w3-center">Booked Events</h2>
    <?php
    // Get the user ID from session
    $user_id = $_SESSION['user_id'];

    // Query to retrieve events booked by any user but created by the client
    $sql = "
        SELECT ce.id, ce.event_name, ce.event_date, ce.event_description, ce.location, ce.image
        FROM client_events ce
        INNER JOIN bookings b ON b.event_id = ce.id
        WHERE ce.created_by = ?
        ORDER BY ce.event_date ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<table class="w3-table w3-striped w3-bordered">';
        echo '<tr><th>Event Name</th><th>Date</th><th>Description</th><th>Location</th><th>Image</th><th>Action</th></tr>';
        // Output each booked event
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['event_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['event_date']) . '</td>';
            echo '<td>' . nl2br(htmlspecialchars($row['event_description'])) . '</td>';
            echo '<td>' . htmlspecialchars($row['location']) . '</td>';
            echo '<td><img src="data:image/jpeg;base64,' . htmlspecialchars($row['image']) . '" alt="Event Image" style="width:100px;height:auto;border-radius:8px;"></td>';
            echo '<td><a href="view-participants.php?event_id=' . $row['id'] . '" class="view-participants-btn">View Participants</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "<p>No events booked by any user for events created by you.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
</div>
<?php endif ?>
