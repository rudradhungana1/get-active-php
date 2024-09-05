<?php include "../includes/header.php" ?>

<style>
    .event-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        transition: box-shadow 0.3s ease;
    }

    .event-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .event-card h2 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 2.2em;
        font-weight: bold;
        color: #333;
    }

    .event-card p {
        margin: 0;
        margin-bottom: 10px;
        font-size: 1.1em;
        line-height: 1.6;
        color: #555;
    }

    .event-card img {
        width: 100%;
        height: 400px;
        max-height: 400px;
        border-radius: 8px;
        margin-bottom: 20px;
        object-fit: cover;
    }

    .event-details {
        margin-top: 20px;
    }

    .event-details p {
        margin-bottom: 10px;
        color: #666;
    }

    .book-event-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 25px;
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 1em;
        transition: background-color 0.3s ease, transform 0.3s ease;
        text-align: center;
    }

    .book-event-btn:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    .booked-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 25px;
        background-color: #d3d3d3;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 1em;
        text-align: center;
        cursor: not-allowed;
    }
</style>

<div class="w3-content container" style="margin-top:100px;">
    <?php
    if (isset($_GET['id'])) {
        $eventId = $_GET['id'];

        $userId = $_SESSION['user_id'];

        $sql = "SELECT * FROM client_events WHERE id = $eventId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $checkBookingSql = "SELECT * FROM bookings WHERE user_id = $userId AND event_id = $eventId";
            $bookingResult = $conn->query($checkBookingSql);
            $isBooked = $bookingResult->num_rows > 0;
            ?>
            <div class="event-card">
                <h2><?php echo htmlspecialchars($row['event_name']); ?></h2>
                <img src="data:image/jpeg;base64,<?php echo htmlspecialchars($row['image']); ?>" alt="Event Image">
                <div class="event-details">
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($row['event_date']); ?></p>
                    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($row['event_description'])); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p><strong>Time:</strong> <?php echo htmlspecialchars($row['event_date']); ?></p>
                </div>
            <?php if (is_logged_in()): ?>

                <?php if ($isBooked): ?>
                    <span class="booked-btn">Booked</span>
                <?php else: ?>
                    <a href="../controllers/bookingController.php?event_id=<?php echo $eventId; ?>" class="book-event-btn">Book Event</a>
                <?php endif; ?>
                <?php endif; ?>

            </div>
            <?php
        } else {
            echo "<p>Event not found.</p>";
        }

        $conn->close();
    } else {
        echo "<p>No event ID provided.</p>";
    }
    ?>
</div>

<?php include "../includes/footer.php" ?>
