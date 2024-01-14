<?php
session_start();

// Check if the user is logged in as an admin
if (isset($_SESSION["user_id"]) && $_SESSION["type"] == "admin") {
    // Include your database connection code here
    include("connection.php");

    // Fetch student data from the users table
    $sql = "SELECT id, username, password, full_name, email FROM users WHERE type = 'student'";
    $result = $conn->query($sql);

    // Close the database connection
    $conn->close();
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
            <!-- Include your CSS styles here -->
            <style> html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .content {
            flex-grow: 1;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
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
        padding: 10px 15px;
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
    }
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
            </a>

            <!-- Navigation links on the left and "Logout" button on the right -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Students
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="admin_dashboard.php?action=manage_students">Requests</a>
                            </li>
                            <li><a class="dropdown-item" href="view_student_credentials.php">Credentials</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_topics_questions.php">Quizzes</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <!-- "Logout" link with custom class -->
                        <a class="nav-link register-btn" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>    <div class="content">

    <div class="container">
    <h2 class="mt-5 mb-4">Student Data</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username (Student ID)</th>
                    <th>Password</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["password"] . "</td>";
                    echo "<td>" . $row["full_name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";

                    // Add a "Send Email", "Edit", and "Delete" buttons within the same cell
                    echo '<td>
                        <form method="post" action="compose_email.php" class="d-inline">
                            <input type="hidden" name="email" value="' . $row["email"] . '">
                            <input type="hidden" name="username" value="' . $row["username"] . '">
                            <input type="hidden" name="fullname" value="' . $row["full_name"] . '">
                            <input type="hidden" name="password" value="' . $row["password"] . '">
                            <button type="submit" class="btn btn-primary">Send Email</button>
                        </form>
                        
                        <form method="post" action="edit_student.php" class="d-inline">
                            <input type="hidden" name="id" value="' . $row["id"] . '">
                            <button type="submit" class="btn btn-success">Edit</button>
                        </form>
                        
                        <form method="post" action="delete_student.php" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this student?\');">
                            <input type="hidden" name="id" value="' . $row["id"] . '">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>';

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Add Bootstrap and jQuery JS scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
   
    </body>
    </html>

    <?php
} else {
    // Redirect to the login page if the user is not logged in as an admin
    header("Location: index.php");
    exit();
}
?>