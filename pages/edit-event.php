<?php
include "../includes/sidebar.php";

if(isset($_GET['id'])) {
    $event_id= $_GET['id'];

    $sql = "SELECT * FROM client_events WHERE id = $event_id";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        $event_datetime = date('Y-m-d\TH:i', strtotime($event['event_date']));

        if($event['created_by'] != $_SESSION['user_id']){
            $_SESSION['error_message'] = "You don't have permission to edit this event!";
            exit();
        }

    } else {
        header("Location: events_list.php");
        exit();
    }
} else {
    header("Location: events_list.php");
    exit();
}
?>
<?php if ($_SESSION['user_type'] == 'client'): ?>

<div class="w3-content container" style="margin-top: 100px; max-width: 800px;">

    <h2 class="w3-center">Edit Client Event</h2>
    <form action="../controllers/editEventController.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">

        <div class="w3-section">
            <label for="event_name">Event Name</label>
            <input type="text" class="w3-input w3-border" id="event_name" name="event_name" value="<?php echo htmlspecialchars($event['event_name']); ?>" required>
        </div>
        <div class="w3-section">
            <label for="event_description">Event Description</label>
            <textarea class="w3-input w3-border" id="event_description" name="event_description" rows="4" required><?php echo htmlspecialchars($event['event_description']); ?></textarea>
        </div>
        <div class="w3-section">
            <label for="event_date">Date and Time</label>
            <input type="datetime-local" class="w3-input w3-border" id="event_date" name="event_date" value="<?php echo $event_datetime; ?>" min="<?php echo $event_datetime; ?>" required>
        </div>
        <div class="w3-section">
            <label for="location">Location</label>
            <input type="text" class="w3-input w3-border" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>
        </div>
        <div class="w3-section">
            <label for="max_participants">Maximum Participants</label>
            <input type="number" class="w3-input w3-border" id="max_participants" name="max_participants" value="<?php echo htmlspecialchars($event['max_participants']); ?>" required>
        </div>
        <div class="w3-section">
            <label for="facility_id">Facility</label>
            <select class="w3-input w3-border" id="facility_id" name="facility_id" required>
                <option value="">Select Facility</option>
                <?php
                $sql = "SELECT id, title FROM facility";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $selected = ($row['id'] == $event['facility_id']) ? 'selected' : '';
                        echo '<option value="' . $row['id'] . '" ' . $selected . '>' . htmlspecialchars($row['title']) . '</option>';
                    }
                } else {
                    echo '<option value="">No facilities available</option>';
                }
                ?>
            </select>
        </div>
        <?php if($event['image']): ?>
            <div class="w3-section">
                <img src="data:image/jpeg;base64,<?php echo $event['image']; ?>" alt="Event Image" style="max-width: 200px; object-fit: cover;">
            </div>
        <?php endif; ?>
        <div class="w3-section">
            <label for="image">Image (optional)</label>
            <input type="file" class="w3-input w3-border" id="image" name="image" accept="image/*">
        </div>
        <div class="w3-section">
            <button type="submit" class="w3-button w3-green">Update Event</button>
        </div>
    </form>
</div>
<?php endif ?>



<?php include "../includes/footer.php" ?>
