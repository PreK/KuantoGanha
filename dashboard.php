<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
}
include 'sidebar.php';
?>
<h1>Welcome to the Dashboard</h1>