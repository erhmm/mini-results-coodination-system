<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

include 'connect.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM results WHERE id = '$id'");

header("Location: dashboard.php");
exit;
?>
