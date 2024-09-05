<?php include '../includes/header.php'; ?>

<!--contact form-->

<style>
    .contact-container {
        width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        margin-top: 100px;
        color: #1f1e1e;
    }

    .contact-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .contact-container form {
        display: flex;
        flex-direction: column;
    }

    .contact-container label {
        margin-bottom: 2px;
    }

    .contact-container input[type="text"],
    .contact-container input[type="email"],
    .contact-container textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .contact-container textarea {
        height: 100px;
    }

    .contact-container input[type="submit"] {
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .contact-container input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>

    <div class="contact-container">
        <h2>Contact Us</h2>
        <form action="../controllers/contactController.php" method="post">
            <label for="subject">Subject:</label><br>
            <input type="text" id="subject" name="subject" required><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>

            <label for="message">Message:</label><br>
            <textarea id="message" name="message" rows="4" required></textarea><br>

            <input type="submit" value="Submit">
        </form>
    </div>


<?php include '../includes/footer.php'; ?>