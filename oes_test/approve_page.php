<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["approve"])) {
    if (isset($_POST["student_id"])) {
        $student_id = $_POST["student_id"];
        
        // Fetch the student's data from the pending_students table
        $stmt = $conn->prepare("SELECT * FROM pending_students WHERE id = ?");
        $stmt->bind_param("i", $student_id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                
                // Generate a unique ID (e.g., combining name and year of birth)
               $last_4_chars = substr($row["full_name"], -4); // Get the last 4 characters of full_name
$unique_id = $last_4_chars . date("Y", strtotime($row["date_of_birth"]));


                
                // Generate a random 5-character password with letters and numbers
                $random_password = generateRandomPassword();
                
                // Insert the student's data into the new table with ID and password
                $insert_stmt = $conn->prepare("INSERT INTO users (type, username, email, full_name, date_of_birth, subject, class, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $user_type = "student";
                $username = $unique_id;
                $email = $row["email"];
                $full_name = $row["full_name"];
                $date_of_birth = $row["date_of_birth"];
                $subject = $row["subject"];
                $class = $row["class"];
                
                $insert_stmt->bind_param("ssssssss", $user_type, $username, $email, $full_name, $date_of_birth, $subject, $class, $random_password);
                
                if ($insert_stmt->execute()) {
                    // Data has been successfully transferred to the new table
                    // Now, delete the data from the pending_students table
                    $delete_stmt = $conn->prepare("DELETE FROM pending_students WHERE id = ?");
                    $delete_stmt->bind_param("i", $student_id);
                    
                    if ($delete_stmt->execute()) {
                        $error_message = "Student has been approved and added to the new table.";
                        echo "<script>";
                        echo "alert('$error_message');";
                        echo "window.location.href = 'manage_students.php';"; // Replace 'redirect_page.php' with the actual URL you want to redirect to.
                        echo "</script>";
                    } else {
                        $error_message = "Failed to delete student data from pending table.";
                    }
                    
                    $delete_stmt->close();
                } else {
                    $error_message = "Failed to insert student data into the new table.";
                }
                
                $insert_stmt->close();
            } else {
                $error_message = "Student data not found in pending table.";
            }
        } else {
            $error_message = "Failed to fetch student data from pending table.";
        }
        
        $stmt->close();
    } else {
        $error_message = "Student ID not provided.";
    }
} else {
    // Handle the case where the "Approve" button was not clicked or the form was not submitted.
    // Redirect or display an error message as needed.
}

$conn->close();

// Function to generate a random 5-character password with letters and numbers
function generateRandomPassword() {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $password = "";
    
    for ($i = 0; $i < 5; $i++) {
        $index = rand(0, strlen($characters) - 0);
        $password .= $characters[$index];
    }
    
    return $password;
}
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
