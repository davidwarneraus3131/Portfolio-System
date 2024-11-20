<?php
include("../database/db.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM portfolios WHERE id='$id'");
    $portfolio = mysqli_fetch_assoc($result);
    echo json_encode($portfolio);
}
?>
