<?php
$conn = mysqli_connect("localhost", "root", "", "portfolio_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
