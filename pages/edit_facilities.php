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
        width: 600px;
        margin-top: 6rem;
    }
    .form-box h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .form-box .input-field {
        margin-bottom: 15px;
    }
    .form-box .input-field label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    .form-box .input-field input,
    .form-box .input-field textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .form-box .input-field input[type="file"] {
        padding: 3px;
    }
    .form-box .input-field select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .form-box .submit-btn {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .form-box .submit-btn:hover {
        background-color: #0056b3;
    }
</style>

<?php
include "../includes/sidebar.php";

if(isset($_GET['id'])) {
    $facility_id = $_GET['id'];

    $sql = "SELECT * FROM facility WHERE id = $facility_id";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $facility = $result->fetch_assoc();

        if($facility['created_by'] != $_SESSION['user_id']){
            $_SESSION['error_message'] = "You don't have permission to edit this facility!";
            exit();
        }

    } else {
        header("Location: facilities_list.php");
        exit();
    }
} else {
    header("Location: facilities_list.php");
    exit();
}
?>

<div class="container-tool">
    <div class="form-box">
        <h2>Edit Facility</h2>
        <form action="../controllers/editFacilityController.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="facility_id" value="<?php echo $facility['id']; ?>">
            <div class="input-field">
                <label for="title">Facility Title</label>
                <input type="text" id="title" name="title" value="<?php echo $facility['title']; ?>" required>
            </div>
            <div class="input-field">
                <label for="image">Current Image</label>
                <img src="data:image/jpeg;base64,<?php echo $facility['image']; ?>" alt="Facility Image" style="max-width: 200px; object-fit: cover;">
            </div>
            <div class="input-field">
                <label for="new_image">New Image</label>
                <input type="file" id="new_image" name="new_image" accept="image/*">
            </div>
            <div class="input-field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required><?php echo $facility['description']; ?></textarea>
            </div>
            <div class="input-field">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="tennis" <?php echo ($facility['category'] == 'tennis') ? 'selected' : ''; ?>>Tennis</option>
                    <option value="basketball" <?php echo ($facility['category'] == 'basketball') ? 'selected' : ''; ?>>Basketball</option>
                    <option value="swimming" <?php echo ($facility['category'] == 'swimming') ? 'selected' : ''; ?>>Swimming</option>
                    <option value="football" <?php echo ($facility['category'] == 'football') ? 'selected' : ''; ?>>Football</option>
                    <option value="gym" <?php echo ($facility['category'] == 'gym') ? 'selected' : ''; ?>>Gym</option>
                    <option value="badminton" <?php echo ($facility['category'] == 'badminton') ? 'selected' : ''; ?>>Badminton</option>
                </select>
            </div>
            <div class="input-field">
                <label for="distance">Distance</label>
                <select id="distance" name="distance" required>
                    <option value="5" <?php echo ($facility['distance'] == '5') ? 'selected' : ''; ?>>Within 5 miles</option>
                    <option value="10" <?php echo ($facility['distance'] == '10') ? 'selected' : ''; ?>>Within 10 miles</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">Update Facility</button>
        </form>
    </div>
</div>
