<?php 
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION["type"] == "student") {

    header("Location: student_dashboard.php");

}
else if (isset($_SESSION["user_id"]) && $_SESSION["type"] == "admin") {

    header("Location: admin_dashboard.php");

}

include("connection.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $full_name = $_POST["full_name"];
    $date_of_birth = $_POST["date_of_birth"];
    $subject = $_POST["subject"];
    $class = $_POST["class"];

    // Validate user input (e.g., check for empty fields, validate email format, etc.)
    // Insert the registration request into the database with "pending" status
    $stmt = $conn->prepare("INSERT INTO pending_students (email, full_name, date_of_birth, subject, class) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $full_name, $date_of_birth, $subject, $class);

    if ($stmt->execute()) {
        $message = "Request sent to admin. An email will be sent to you with id and password after approval.";
        echo "<script>";
        echo "alert('$message');";
        echo "window.location.href = 'index.php';"; // Replace 'redirect_page.php' with the actual URL you want to redirect to.
        echo "</script>";
    } else {
        $error_message = "Registration request failed. Please try again.";
        echo "<script>";

        echo "alert('$error_message');";
        echo "window.location.href = 'index.php';"; // Replace 'redirect_page.php' with the actual URL you want to redirect to.
        echo "</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Exam System</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="icon" href="favicon.png" width="50px" type="image/x-icon">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your custom CSS styles here -->
    <!-- Add your custom CSS styles here -->
    <style>
       html {
            height: 100%;
        }

        body {
            min-height: 100%;
            margin-bottom: 60px; /* Adjust this value as needed */
        }

        .footer {
            width: 100%;
            background-color: #f8f9fa; /* Adjust the background color as needed */
            padding: 10px 0;
            text-align: center;
            position: relative;
        }

        .content {
            padding-bottom: 70px; /* Equal to or greater than the footer's height */
        }

        .navbar .navbar-brand {
            display: flex;
            align-items: center;
        }
    /* body{
    background-color: #ca5cdd
} */

    .navbar .navbar-brand img {
        width: 40px;
        /* Adjust the width as needed */
        margin-right: 10px;
        /* Add some spacing between the icon and text */
    }

    .container {
        margin-top: 1px;
    }

    .header {
        background-color: #333;
        color: #fff;
        padding: 0.5px 2;
    }

    .footer {
        color:black;
        padding: 1px 2;
        text-align: center;
        margin-top: 40px;
    }

    .footer ul {
        list-style: none;
        padding: 0;
    }

    .footer ul li {
        display: inline;
        margin-right: 10px;
    }

    .card {
        margin-top: 20px;
        margin-bottom:50px
    }

    /* Navbar text color */
    .navbar-brand {
        color:black;
        transition: color 0.4s;
        /* Smooth transition on hover */

    }
.card-body{
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);

}
    .navbar-nav .nav-link {
        color: black;
        transition: color 0.4s;
        /* Smooth transition on hover */
    }

    /* Navbar link hover color */
    .navbar-nav .nav-link:hover,
    .navbar-brand:hover,
    .colored ,.footer a{
        color: #ca5cdd;

    }
   footer a:hover, .colored:hover{

 color: #be2ed6;
 text-decoration:underline;
    }

    .navbar-nav .register-btn,
    .colored-btn {
        background-color: #ca5cdd;
        color: white;
        /* Adjust the value to control the button's roundness */
        transition: background-color 0.3s, color 0.4s;
        /* Smooth transition on hover */
    }
    
    .navbar-nav .register-btn
    {
        border-radius: 30px;

    }

    .nav-link {
        padding: 10px 40px;
    }

    .navbar-expand-lg .navbar-nav .nav-link {
        padding: 10px 25px;
    }

    /* Style for the "Register" button on hover */
    .navbar-nav .register-btn:hover,
    .colored-btn:hover {
        background-color: #be2ed6;
        color: white;
    }

    .form-heading {
        text-align: center;
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
        margin-top:50px
    }
    /* Remove the blue outline on input focus */
.form-control:focus {
    /* outline:none; */
    border:none;
    /* border-color: #ca5cdd; */
    box-shadow: 0 0 0 3px rgba(202, 92, 221, 0.3);
}

    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm sticky-top">
        <div class="container">
            <!-- Icon on the left -->
            <a class="navbar-brand" href="#">
                <img src="favicon.png" alt="Icon">
                Online Exam System
            </a>

            <!-- Navigation links on the right -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <!-- "Register" link with custom class -->
                        <a class="nav-link register-btn" href="index.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <h1 class="form-heading">Register Form</h1>

                <div class="card shadow-sm">
                    <div class="card-body">

                        <form action="register.php" method="POST">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="full_name">Full Name:</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth:</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="class">Class:</label>
                                <select class="form-control" id="class" name="class" required>
                                    <option value="" disabled selected>Select your class</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>

                                </select>                            </div>
                            <div class="form-group">
                                <label for="subject">Subject:</label>
                                <select class="form-control" id="subject" name="subject" required>
                                    <option value="" disabled selected>Select a subject</option>
                                    <option value="english">English</option>
                                    <option value="maths">Maths</option>
                                    <option value="computer_science">Computer Science</option>
                                </select>
                            </div>



                            <button type="submit" class="btn colored-btn btn-block">Register</button>
                        </form>
                        <p class="mt-3 text-center">Already registered? <a class="colored" href="index.php">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <div class="footer">
        <div class="container">
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Contact Us</a></li>
                <li class="list-inline-item"><a href="#">Terms of Service</a></li>
                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
            </ul>
            <p>&copy; 2023 Online Exam System</p>
        </div>
    </div>

    <!-- Add Bootstrap and jQuery JS scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>