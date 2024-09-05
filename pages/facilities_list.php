<?php
include "../includes/sidebar.php";


$userId = $_SESSION['user_id'];
// Retrieve data from the tools table
$sql = "SELECT * FROM facility where created_by = $userId";
$result = $conn->query($sql);

?>
<style>
    .container {
        margin-top: 20px;
        padding: 20px;
        color: black
    }

    h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody tr:hover {
        background-color: #f2f2f2;
    }

    .action-buttons {
        display: flex;
        justify-content: space-between;
    }

    .action-buttons button {
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .action-buttons button.edit {
        background-color: #007bff;
        color: #fff;
    }

    .action-buttons button.delete {
        background-color: #dc3545;
        color: #fff;
    }
</style>

<div class="w3-main" style="margin-left:250px">

    <div class="container">
        <h2>Facilities List</h2>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td class='action-buttons'>";
                    echo "<button class='edit' onclick='goToEdit(" . $row["id"] . ")'>Edit</button>";
                    echo "<button class='delete' onclick='confirmDelete(" . $row["id"] . ")'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No Facilities found</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(toolId) {
        if (confirm("Are you sure you want to delete this facility?")) {
            window.location.href = "../controllers/deleteFacilityController.php?id=" + toolId;
        }
    }

    function goToEdit(toolId) {
        window.location.href = "../pages/edit_facilities.php?id=" + toolId;
    }
</script>
