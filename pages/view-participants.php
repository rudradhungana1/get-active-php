<?php include "../includes/sidebar.php" ?>

<style>
    .container {
        margin-top: 100px;
        max-width: 800px;
    }

    .event-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .participants-list {
        margin-bottom: 20px;
    }

    .participant {
        margin-bottom: 10px;
        font-size: 16px;
        color: #666;
    }

    .participants-left {
        font-weight: bold;
        color: white;
        background: black;
        padding: 10px;
        border-radius: 10px;
    }
    .participants-table {
        width: 100%;
        border-collapse: collapse;
    }

    .participants-table th,
    .participants-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ccc;
    }

    .participants-table th {
        background-color: #f2f2f2;
        font-weight: bold;
        color: #333;
    }

    .participants-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .participant-username {
        color: #333;
        font-weight: bold;
    }

    .participant-email {
        color: #666;
    }

</style>

<div class="w3-content container">
    <?php
    // Check if the event ID is provided in the URL
    if (isset($_GET['event_id'])) {
        $eventId = $_GET['event_id'];

        // Query to retrieve the event details
        $sql_event = "SELECT event_name FROM client_events WHERE id = ?";
        $stmt_event = $conn->prepare($sql_event);
        $stmt_event->bind_param("i", $eventId);
        $stmt_event->execute();
        $result_event = $stmt_event->get_result();

        if ($result_event->num_rows > 0) {
            $event_row = $result_event->fetch_assoc();
            $event_name = htmlspecialchars($event_row['event_name']);
            echo "<h2 class='event-title'>$event_name Participants</h2>";
        } else {
            echo "<p>Event not found.</p>";
        }

        // Query to retrieve participants for the event
        $sql_participants = "SELECT u.username FROM bookings b INNER JOIN users u ON b.user_id = u.id WHERE b.event_id = ?";
        $stmt_participants = $conn->prepare($sql_participants);
        $stmt_participants->bind_param("i", $eventId);
        $stmt_participants->execute();
        $result_participants = $stmt_participants->get_result();

        if ($result_participants->num_rows > 0) {
            echo "<div class='participants-list'>";
            echo "<h3>Participants:</h3>";
            echo "<table class='participants-table'>";
            echo "<thead><tr><th>Username</th><th>Email</th></tr></thead>";
            echo "<tbody>";
            while ($row = $result_participants->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='participant-username'>" . htmlspecialchars($row['username']) . "</td>";
                // Add more columns if needed
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p>No participants booked for this event yet.</p>";
        }


        // Calculate and show participants left to book
        $sql_max_participants = "SELECT max_participants FROM client_events WHERE id = ?";
        $stmt_max_participants = $conn->prepare($sql_max_participants);
        $stmt_max_participants->bind_param("i", $eventId);
        $stmt_max_participants->execute();
        $result_max_participants = $stmt_max_participants->get_result();

        if ($result_max_participants->num_rows > 0) {
            $row_max = $result_max_participants->fetch_assoc();
            $max_participants = $row_max['max_participants'];

            $sql_booked_participants = "SELECT COUNT(*) AS booked_count FROM bookings WHERE event_id = ?";
            $stmt_booked_participants = $conn->prepare($sql_booked_participants);
            $stmt_booked_participants->bind_param("i", $eventId);
            $stmt_booked_participants->execute();
            $result_booked_participants = $stmt_booked_participants->get_result();

            if ($result_booked_participants->num_rows > 0) {
                $row_booked = $result_booked_participants->fetch_assoc();
                $booked_count = $row_booked['booked_count'];

                $participants_left = $max_participants - $booked_count;
                echo "<p class='participants-left'>$participants_left Participants Left to Book</p>";
            }
        }
    } else {
        echo "<p>No event ID provided.</p>";
    }
    ?>
</div>
