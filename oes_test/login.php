<?php 
session_start();

// Redirection based on session type
if (isset($_SESSION["type"])) {
    $type = $_SESSION["type"];
    
    switch ($type) {
        case 'admin':
            header("Location: admin_dashboard.php");
            exit(); // Ensure no more output is sent
            break;
            
        case 'student':
            header("Location: student_dashboard.php");
            exit(); // Ensure no more output is sent
            break;
        default:
            // Handle any other type here, or redirect to a default page
            header("Location: index.php"); // Replace with the appropriate default page
            exit(); // Ensure no more output is sent
            break;
    }
}

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginAs = $_POST["loginAs"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate user input (e.g., check for empty fields)

    // Connect to the database (Replace with your database credentials)
    // Prepare and execute the SQL query (without password hashing)
    $stmt = $conn->prepare("SELECT id, username, password, type FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // Bind username only
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify the password (using password_verify if passwords are hashed)
        if ($user["type"] == "admin" && $loginAs == "admin" && $password == $user["password"]) {
            // Redirect to admin dashboard
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["type"] = $user["type"];
            header("Location: admin_dashboard.php");
            exit();
        } elseif ($user["type"] == "student" && $loginAs == "student" && $password == $user["password"]) {
            // Redirect to student dashboard
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["type"] = $user["type"];
            header("Location: student_dashboard.php");
            exit();
        } else {
            // Invalid role or password
            $error_message = "Invalid role or login credentials.";
            echo "<script>";
            echo "alert('$error_message');";
            echo "window.location.href = 'index.php';"; // Replace 'index.php' with the actual URL you want to redirect to.
            echo "</script>";
        }
    } else {
        // User not found
        $error_message = "User not found.";
        echo "<script>";
        echo "alert('$error_message');";
        echo "window.location.href = 'index.php';"; // Replace 'index.php' with the actual URL you want to redirect to.
        echo "</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
