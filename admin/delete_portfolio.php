<?php
include("../database/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"], $_POST["resume"])) {
    $id = intval($_POST["id"]);
    $resume = $_POST["resume"];
    $resumePath = "../assets/resume/" . $resume;

    // Delete portfolio from database
    $deleteQuery = "DELETE FROM portfolios WHERE id = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Remove the resume file if it exists
        if (file_exists($resumePath)) {
            unlink($resumePath);
        }
        echo "success";
    } else {
        echo "error";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
