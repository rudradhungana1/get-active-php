<?php include "../includes/header.php"; ?>

<style>
    .facility-details-page {
        margin-top: 100px;
    }

    .facility-details-page header {
        text-align: center;
        margin-bottom: 20px;
        background-color: rgb(48 96 5 / 80%);
    }

    .facility-details-page header h1 {
        color: #ffffff;
    }

    /* Facility details styles */
    .facility-details {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .facility-details img {
        width: 100%;
        max-width: 600px;
        height: auto;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .facility-details h2,
    .facility-details p {
        color: #483e3e;
        text-align: left;
        margin-bottom: 10px;
    }

    /* Event card styles */
    .event-card {
        width: calc(50% - 20px);
        margin-right: 20px;
        margin-bottom: 20px;
        float: left;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        background-color: #f9f9f9;
    }

    .event-card:nth-child(2n) {
        margin-right: 0;
        clear: both;
    }

    .event-card h3 {
        margin-top: 0;
        margin-bottom: 10px;
        color: black;
    }

    .event-card p {
        margin: 0;
        color: #555;
    }

    .event-card img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    /* Button styles */
    .book-btn {
        display: block;
        margin-top: 10px;
        padding: 10px 20px;
        color: #fff;
        background-color: #007bff;
        border-radius: 5px;
        text-decoration: none;
        text-align: center;
    }

    .book-btn:hover {
        background-color: #0056b3;
    }
</style>

<?php

if(isset($_GET['id'])) {
    $facility_id = $_GET['id'];

    // Fetch facility details
    $sql_facility = "SELECT * FROM facility WHERE id = ?";
    $stmt_facility = $conn->prepare($sql_facility);
    $stmt_facility->bind_param("i", $facility_id);
    $stmt_facility->execute();
    $result_facility = $stmt_facility->get_result();

    if($result_facility->num_rows > 0) {
        $facility = $result_facility->fetch_assoc();
    } else {
        $_SESSION['error_message'] = "Facility not found.";
        header("Location: facilities.php");
        exit();
    }

} else {
    header("Location: facilities.php");
    exit();
}

$sql_events = "SELECT * FROM client_events WHERE facility_id = ?";
$stmt_events = $conn->prepare($sql_events);
$stmt_events->bind_param("i", $facility_id);
$stmt_events->execute();
$result_events = $stmt_events->get_result();
?>

<div class="facility-details-page w3-content">
    <header>
        <h1><?php echo $facility['title']; ?></h1>
    </header>

    <div class="facility-details">
        <img src="data:image/jpeg;base64,<?php echo $facility['image']; ?>" alt="Facility Image">
        <h2>Description</h2>
        <p><?php echo $facility['description']; ?></p>
    </div>

    <div class="events-list">
        <header>
            <h2>Associated Events</h2>
        </header>

        <?php
        if ($result_events->num_rows > 0) {
            while ($event = $result_events->fetch_assoc()) {
                ?>
                <div class="event-card">
                    <h3><?php echo htmlspecialchars($event['event_name']); ?></h3>
                    <img src="data:image/jpeg;base64,<?php echo $event['image']; ?>" alt="Event Image">
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?></p>
                    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($event['event_description'])); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                    <?php if (is_logged_in()): ?>
                        <a href='view-event.php?id=<?php echo $event['id']; ?>' class="book-btn">View Event</a>
                    <?php endif; ?>
                </div>
                <?php
            }
        } else {
            echo "<p>No events associated with this facility.</p>";
        }
        ?>
    </div>
</div>
