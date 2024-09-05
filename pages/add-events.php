<?php include "../includes/sidebar.php" ?>
<?php if ($_SESSION['user_type'] == 'client'): ?>

<div class="w3-content container" style="margin-top: 100px; max-width: 800px;">


    <h2 class="w3-center">Add Client Event</h2>
    <form action="../controllers/addEventController.php" method="post" enctype="multipart/form-data">
        <div class="w3-section">
            <label for="event_name">Event Name</label>
            <input type="text" class="w3-input w3-border" id="event_name" name="event_name" required>
        </div>
        <div class="w3-section">
            <label for="event_description">Event Description</label>
            <textarea class="w3-input w3-border" id="event_description" name="event_description" rows="4" required></textarea>
        </div>
        <div class="w3-section">
            <label for="event_date">Date and Time</label>
            <input type="datetime-local" class="w3-input w3-border" id="event_date" name="event_date" required>
        </div>
        <div class="w3-section">
            <label for="location">Location</label>
            <input type="text" class="w3-input w3-border" id="location" name="location" required>
        </div>
        <div class="w3-section">
            <label for="max_participants">Maximum Participants</label>
            <input type="number" class="w3-input w3-border" id="max_participants" name="max_participants" required>
        </div>
        <div class="w3-section">
            <label for="facility_id">Facility</label>
            <select class="w3-input w3-border" id="facility_id" name="facility_id" required>
                <option value="">Select Facility</option>
                <?php
                // Fetch facilities from the database
                $sql = "SELECT id, title FROM facility";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                    }
                } else {
                    echo '<option value="">No facilities available</option>';
                }
                ?>
            </select>
        </div>
        <div class="w3-section">
            <label for="image">Image</label>
            <input type="file" class="w3-input w3-border" id="image" name="image" accept="image/*" required>
        </div>
        <div class="w3-section">
            <button type="submit" class="w3-button w3-green">Add Event</button>
        </div>
    </form>
</div>


<?php include "../includes/footer.php" ?>
<?php endif ?>
