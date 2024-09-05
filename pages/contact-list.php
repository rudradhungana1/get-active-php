<?php include "../includes/sidebar.php"; ?>

<?php
// Fetch contact data from the database
$sql = "SELECT email, subject, message FROM contact";
$result = $conn->query($sql);
?>
<?php if ($_SESSION['user_type'] == 'admin'): ?>

<div class="w3-content container">
    <h2>Contact List</h2>
    <div class="contact-list">
        <table>
            <thead>
            <tr>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No contacts found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "../includes/footer.php"; ?>

<style>
    .container {
        margin-top: 100px;
        padding: 20px;
    }

    .contact-list table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #f9f9f9;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .contact-list th, .contact-list td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .contact-list th {
        background-color: #4CAF50;
        color: white;
    }

    .contact-list td {
        color: #333;
    }

    .contact-list tr:hover {
        background-color: #f1f1f1;
    }
</style>
<?php endif; ?>
