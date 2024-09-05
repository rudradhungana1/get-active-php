<?php include "../includes/header.php" ?>

<style>
    .event-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        position: relative;
    }

    .event-card h3 {
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 1.5em;
        font-weight: bold;
        color: #1f1e1e;
    }

    .event-card p {
        margin: 0;
        color: #1f1e1e;
    }

    .event-card img {
        width: 100%;
        height: 300px;
        max-height: 400px;
        border-radius: 8px;
        margin-bottom: 10px;
        object-fit: cover;
    }

    .event-details {
        margin-top: 20px;
    }

    .view-event-btn {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        padding: 10px 20px;
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .view-event-btn:hover {
        background-color: #45a049;
    }

    /* Filter Section CSS */
    .filter-section {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .filter-section form {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px;
    }

    .filter-section label {
        font-size: 1em;
        font-weight: bold;
        color: #1f1e1e;
    }

    .filter-section input[type="date"] {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1em;
        background-color: #fff;
    }

    .filter-section button {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .filter-section button:hover {
        background-color: #45a049;
    }

</style>

<div class="w3-content container" style="margin-top:100px;">
    <h2 class="w3-center">Upcoming Events</h2>

    <!-- Filter Section -->
    <div class="filter-section w3-section">
        <form method="post" action="">
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate">
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate">
            <button type="submit">Filter Events</button>
        </form>
    </div>

    <!-- Event Listing Section -->
    <div class="w3-section">
        <?php
        // Include database connection

        // Initialize SQL query
        $sql = "SELECT * FROM client_events WHERE event_date > NOW()";

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Capture and validate form inputs
            $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : null;
            $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : null;

            // Validate date inputs
            if ($startDate && $endDate) {
                $sql .= " AND event_date BETWEEN '$startDate' AND '$endDate'";
            } elseif ($startDate) {
                $sql .= " AND event_date >= '$startDate'";
            } elseif ($endDate) {
                $sql .= " AND event_date <= '$endDate'";
            }
        }

        // Order by event date
        $sql .= " ORDER BY event_date ASC";

        // Execute the query
        $result = $conn->query($sql);

        // Check and display results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='event-card'>";
                echo "<h3>" . htmlspecialchars($row['event_name']) . "</h3>";
                echo "<img src='data:image/jpeg;base64," . htmlspecialchars($row['image']) . "' alt='Event Image'>";
                echo "<div class='event-details'>";
                echo "<p>Date: " . htmlspecialchars($row['event_date']) . "</p>";
                echo "<p>Description: " . htmlspecialchars($row['event_description']) . "</p>";
                echo "</div>";
                if (is_logged_in()):
                    echo "<a href='view-event.php?id=" . htmlspecialchars($row['id']) . "' class='view-event-btn'>View Event</a>";
                endif;

                echo "</div>";
            }
        } else {
            echo "<p>No upcoming events found.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</div>

<?php include "../includes/footer.php" ?>
