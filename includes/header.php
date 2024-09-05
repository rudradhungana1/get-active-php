<?php
include 'db.php';
include 'session.php';
include 'functions.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Get Active</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">

<!--    FAVICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/favicon/site.webmanifest">
</head>
<body>
<header>
    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-card" style="background: linear-gradient(to left, #ffa500, #6fa407);">
            <a href="index.php" class="w3-bar-item w3-button w3-padding-large">HOME</a>
            <a href="../pages/facilities.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">FACILITIES</a>
            <a href="../pages/events.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">EVENTS</a>
            <a href="../pages/contact.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CONTACT</a>
            <div class="w3-dropdown-hover w3-hide-small">
                <button class="w3-padding-large w3-button" title="More">MORE <i class="fa fa-caret-down"></i></button>
                <div class="w3-dropdown-content w3-bar-block w3-card-4">
                    <?php if (is_logged_in()): ?>
                        <?php if ($_SESSION['user_type'] !== 'user'): ?>
                            <a href="../pages/dashboard.php" class="w3-bar-item w3-button">DASHBOARD</a>
                        <?php endif; ?>
                        <a href="../pages/profile.php" class="w3-bar-item w3-button">MY PROFILE</a>

                        <a href="../controllers/logoutController.php" class="w3-bar-item w3-button">LOG OUT</a>
                    <?php else: ?>
                        <a href="login.php" class="w3-bar-item w3-button">LOG IN</a>
                        <a href="register.php" class="w3-bar-item w3-button">REGISTER</a>
                    <?php endif; ?>
                </div>
            </div>
<!--            <a href="javascript:void(0)" class="w3-padding-large w3-hover-red w3-hide-small w3-right"><i class="fa fa-search"></i></a>-->
        </div>
    </div>
</header>

<?php include "alert.php" ?>