<?php
session_start();
include "../includes/db.php";

$_SESSION = array();

// Destroy the session
session_destroy();

header("Location: ../pages/login.php");
exit();
?>
