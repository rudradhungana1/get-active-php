<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['username']);
}

function require_login() {
    if (!is_logged_in()) {
        redirect('/pages/login.php');
    }
}

