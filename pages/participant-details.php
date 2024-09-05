<?php include "../includes/sidebar.php"; ?>

<style>
    .participant-details-page {
        margin-top: 100px;
    }

    .participant-details-page h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #1f1e1e;
        font-weight: bold;
    }

    .w3-table {
        width: 100%;
        border-collapse: collapse;
    }

    .w3-table th,
    .w3-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .w3-table th {
        background-color: #171515;
        font-weight: bold;
    }

    .w3-table tr:nth-child(even) {
        background-color: #342929;
    }

    .w3-table tr:hover {
        background-color: #5d5050;
    }

    .w3-table-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        background-color: black;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .no-participants-message {
        text-align: center;
        color: #1f1e1e;
        font-size: 16px;
    }

    @media (max-width: 768px) {
        .w3-table-container {
            padding: 10px;
        }

        .w3-table th,
        .w3-table td {
            padding: 8px;
        }
    }
</style>

<div class="w3-content participant-details-page">
    <h2>Participant Details</h2>
    <?php

    if (isset($_GET['facility_id'])) {
        $facility_id = intval($_GET['facility_id']);

        // Query to get the facility title
        $sql_facility = "SELECT title FROM facility WHERE id = ?";
        $stmt_facility = $conn->prepare($sql_facility);
        $stmt_facility->bind_param("i", $facility_id);
        $stmt_facility->execute();
        $result_facility = $stmt_facility->get_result();
        $facility_title = $result_facility->fetch_assoc()['title'];

        // Query to get participants for the specified facility
        $sql_participants = "
        SELECT 
            u.username, 
            u.email
        FROM 
            bookings b
        JOIN 
            users u ON b.user_id = u.id
        WHERE 
            b.facility_id = ?";
        $stmt_participants = $conn->prepare($sql_participants);
        $stmt_participants->bind_param("i", $facility_id);
        $stmt_participants->execute();
        $result_participants = $stmt_participants->get_result();
        ?>

        <div class="w3-table-container">
            <h3>Facility Title: <?php echo htmlspecialchars($facility_title); ?></h3>
            <?php if ($result_participants->num_rows > 0): ?>
                <table class="w3-table w3-bordered w3-striped">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result_participants->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-participants-message">No participants found for this facility.</p>
            <?php endif; ?>
        </div>

        <?php
        $stmt_facility->close();
        $stmt_participants->close();
    } else {
        echo "<p class='no-participants-message'>No facility ID provided.</p>";
    }
    $conn->close();
    ?>
</div>

<?php include "../includes/footer.php"; ?>
