<?php include "../includes/header.php"; ?>

<style>
    .profile-container {
        margin: 50px auto;
        padding: 20px;
        max-width: 600px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        color: #1f1e1e;
        margin-top: 100px;
    }

    .profile-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-container p {
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .profile-container {
            max-width: 90%;
        }
    }

    .request-membership-btn {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        margin-top: 20px;
    }

    .request-membership-btn:hover {
        background-color: #0056b3;
    }

</style>

<div class="w3-content">
    <div class="profile-container">
        <h2 style="font-weight: bold">User Profile</h2>
        <?php
        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $user_info = getUserInfo($user_id);
            echo "<h4>Username: " . $user_info['username'] . "</h4>";
            echo "<h4>Email: " . $user_info['email'] . "</h4>";
            echo "<h4>Address: " . $user_info['address'] . "</h4>";
            echo "<h4>User Type: " . $user_info['type'] . "</h4>";

            // Check if the user has already requested membership
            $sql = "SELECT * FROM membership_requests WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $membership_request = $result->fetch_assoc();
                $status = $membership_request['status'];
                if ($status == 'approved') {
                    echo '<button type="button" class="request-membership-btn" disabled style="background: #4CAF50">Approved</button>';
                } elseif ($status == 'rejected') {
                    echo '<button type="button" class="request-membership-btn" disabled style="background: red;">Rejected</button>';
                } else {
                    echo '<button type="button" class="request-membership-btn" disabled>Requested</button>';
                }
            } else {
                // User has not requested membership, display the button
                echo '<form action="../controllers/requestMembershipController.php" method="post">';
                echo '<button type="submit" class="request-membership-btn">Request Membership</button>';
                echo '</form>';
            }

        } else {
            echo "<p>Please log in to view your profile.</p>";
        }
        ?>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
