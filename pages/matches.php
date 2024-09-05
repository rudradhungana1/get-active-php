<?php include "../includes/sidebar.php"; ?>

<style>
    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .container h1 {
        text-align: center;
        margin-bottom: 20px;
        color: black;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        color: black;
    }

    th {
        background-color: #f2f2f2;
        color: black;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    .report-button {
        display: block;
        width: 20%;
        padding: 4px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
    }

    .report-button:hover {
        background-color: #0056b3;
    }
</style>

<?php
session_start();

if ($_SESSION['user_type'] != 'admin') {
    $_SESSION['error_message'] = "Access denied. You must be an admin to view this page.";
    header("Location: ../pages/dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedYear = $_POST['year'];

    if (!empty($selectedYear)) {
        $sql = "SELECT * FROM facility WHERE YEAR(date_time) = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $selectedYear);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $sql = "SELECT * FROM facility";
        $result = $conn->query($sql);
    }
} else {
    $sql = "SELECT * FROM facility";
    $result = $conn->query($sql);
}
?>

<div class="w3-content" style="margin-top:100px;">
    <div class="container">
        <h1>Matches</h1>

        <form action="../controllers/generateReportController.php" method="post">
            <div style="display: flex;justify-content: flex-end; gap:10px;">
                <div>
                    <label for="year">Select Year:</label>
                    <select name="year" id="year" class="year-select">
                        <option value="">Select Year</option>
                        <?php
                        $currentYear = date('Y');
                        for ($i = $currentYear; $i >= $currentYear - 10; $i--) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="report-button">Generate Report</button>
            </div>
        </form>

        <table>
            <thead>
            <tr>
                <th>Date</th>
                <th>Facility</th>
                <th>Location</th>
                <th>Participants</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['date_time'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['participants'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No facilities found for the selected year.</td></tr>";
            }
            ?>
            </tbody>
        </table>

    </div>
</div>

<script>
    function setSelectedYear() {
        var selectedYear = document.getElementById("year").value;
        document.getElementById("selected_year").value = selectedYear;
    }
</script>
