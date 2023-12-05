<?php
session_start();
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
}
include 'sidebar.php';
?>
<h1>Welcome to the Dashboard</h1>