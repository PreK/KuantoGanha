<?php
session_start(); // Make sure to start the session

// Check if the user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // User is logged in, redirect to index.php
    header('Location: index.php');
    exit(); // Make sure to terminate the script after the redirection
} else {
    // If the user is not logged in, display an appropriate error message or action
    echo "You are not logged in. <a href='login.php'>Log in</a>";
}
?>