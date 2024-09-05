<?php include "../includes/sidebar.php" ?>

<style>
    .container {
        margin-top: 100px;
        max-width: 800px;
    }
    .w3-center {
        margin-bottom: 20px;
    }
    .w3-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .w3-table th, .w3-table td {
        padding: 10px;
        text-align: left;
    }
    .w3-table th {
        background-color: #f2f2f2;
        color: #333;
    }
    .w3-table tr:nth-child(even) {
        background-color: #f9f9f9;
        color: black;
    }
    .w3-table tr:hover {
        background-color: #f1f1f1;
        color: black;
    }
    .action-buttons {
        display: flex;
        gap: 5px;
    }
    .action-buttons a {
        padding: 5px 10px;
        text-decoration: none;
        color: white;
        border-radius: 3px;
        text-align: center;
    }
    .edit-button {
        background-color: #4CAF50;
    }
    .delete-button {
        background-color: #f44336;
    }
</style>

<div class="w3-content container">
    <h2 class="w3-center">Events List</h2>

    <?php

    // Fetch events from the database
    $sql = "SELECT ce.id, ce.event_name, ce.event_description, ce.event_date, ce.location, ce.max_participants, f.title as facility_title 
            FROM client_events ce
            JOIN facility f ON ce.facility_id = f.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table class="w3-table w3-bordered w3-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Event Name</th>';
        echo '<th>Description</th>';
        echo '<th>Date</th>';
        echo '<th>Location</th>';
        echo '<th>Max Participants</th>';
        echo '<th>Facility</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['event_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['event_description']) . '</td>';
            echo '<td>' . htmlspecialchars($row['event_date']) . '</td>';
            echo '<td>' . htmlspecialchars($row['location']) . '</td>';
            echo '<td>' . htmlspecialchars($row['max_participants']) . '</td>';
            echo '<td>' . htmlspecialchars($row['facility_title']) . '</td>';
            echo '<td class="action-buttons">';
            echo '<a href="edit-event.php?id=' . htmlspecialchars($row['id']) . '" class="edit-button">Edit</a>';
            echo '<a href="javascript:void(0);" class="delete-button" onclick="confirmDelete(' . htmlspecialchars($row['id']) . ')">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="w3-center">No events found.</p>';
    }

    $conn->close();
    ?>
</div>

<script>
    function confirmDelete(eventId) {
        if (confirm("Are you sure you want to delete this event?")) {
            window.location.href = "../controllers/deleteEventController.php?id=" + eventId;
        }
    }
</script>

<?php include "../includes/footer.php" ?>
