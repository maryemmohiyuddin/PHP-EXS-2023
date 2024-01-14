<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reject"])) {
    // Check if a student ID is provided
    if (isset($_POST["student_id"])) {
        $student_id = $_POST["student_id"];
        
        // Delete the student's data from the pending_students table
        $stmt = $conn->prepare("DELETE FROM pending_students WHERE id = ?");
        $stmt->bind_param("i", $student_id);

        if ($stmt->execute()) {
            $error_message = "Student data has been rejected and deleted.";
            echo "<script>";
            echo "alert('$error_message');";
            echo "window.location.href = 'manage_students.php';"; // Replace 'redirect_page.php' with the actual URL you want to redirect to.
            echo "</script>";
        } else {
            $error_message = "Failed to reject student data.";
        }

        $stmt->close();
    } else {
        $error_message = "Student ID not provided.";
    }
} else {
    // Handle the case where the "Reject" button was not clicked or the form was not submitted.
    // Redirect or display an error message as needed.
    // You can also handle the "Approve" action here if necessary.
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your HTML head content here -->
</head>
<body>
    <!-- Your HTML body content here -->
    <?php
    if (isset($message)) {
        echo "<p>$message</p>";
    } elseif (isset($error_message)) {
        echo "<p>$error_message</p>";
    }
    ?>
</body>
</html>
