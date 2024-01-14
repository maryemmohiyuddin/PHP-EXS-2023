<?php
session_start();

// Check if the user is logged in as an admin
if (isset($_SESSION["user_id"]) && $_SESSION["type"] == "admin") {
    // Include your database connection code here
    include("connection.php");

    // Check if the username is provided in the POST data
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Delete the student from the database
        $deleteSql = "DELETE FROM users WHERE type = 'student' AND id = '$id'";
        if ($conn->query($deleteSql) === TRUE) {
            // Redirect back to the student_data.php page after successful deletion
            header("Location: view_student_credentials.php");
            exit();
        } else {
            echo "Error deleting student: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "Username not provided.";
        exit();
    }
} else {
    // Redirect to the login page if the user is not logged in as an admin
    header("Location: index.php");
    exit();
}
?>