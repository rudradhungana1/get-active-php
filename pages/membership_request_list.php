<?php include "../includes/sidebar.php" ?>

<style>
    .container-tool {
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto !important;
        background-color: #f4f4f4;
        color: black;
    }

    .form-box {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 800px;
        margin-top: 6rem;
    }

    .form-box h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    td button {
        padding: 5px 10px;
        margin-right: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    td button[name="approve"] {
        background-color: #4CAF50;
        color: white;
    }

    td button[name="reject"] {
        background-color: #f44336;
        color: white;
    }
</style>


<?php if ($_SESSION['user_type'] === 'admin'): ?>

<div class="container-tool">
    <div class="form-box">
        <h2>Membership Requests</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            // Retrieve data from membership_request table
            $sql = "SELECT * FROM membership_requests";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $user_id = $row['user_id'];
                    $user_sql = "SELECT username FROM users WHERE id = $user_id";
                    $user_result = $conn->query($user_sql);
                    $username = ($user_result->num_rows > 0) ? $user_result->fetch_assoc()['username'] : '';

                    $hide_buttons = ($row['status'] == 'approved' || $row['status'] == 'rejected');


                    echo "<tr>";
                    echo "<td>" . $username . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>";
                    echo '<form action="../controllers/processMembershipController.php" method="post">';
                    echo '<input type="hidden" name="request_id" value="' . $row['id'] . '">';

                    if (!$hide_buttons) {
                        echo '<button type="submit" name="approve">Approve</button>';
                        echo '<button type="submit" name="reject">Reject</button>';
                    }
                    echo '</form>';
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No membership requests found.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>
<?php endif ?>

