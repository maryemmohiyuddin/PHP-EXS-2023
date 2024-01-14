<?php
include("connection.php");

// Check if the question ID is provided in the URL
if (isset($_GET['id'])) {
    $questionId = $_GET['id'];

    // Fetch the question details from the database
    $sql = "SELECT * FROM questions WHERE id = '$questionId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $question = $row['question'];
        $answerA = $row['answerA'];
        $answerB = $row['answerB'];
        $answerC = $row['answerC'];
        $answerD = $row['answerD'];
        $correctAnswer = $row['correctAnswer'];
    } else {
        echo "Question not found.";
        exit;
    }
} else {
    echo "Question ID not provided.";
    exit;
}

// Initialize a variable to store the success message
$successMessage = "";

// Handle form submission for updating the question
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get updated question details from the form
    $updatedQuestion = $_POST['question'];
    $updatedAnswerA = $_POST['answerA'];
    $updatedAnswerB = $_POST['answerB'];
    $updatedAnswerC = $_POST['answerC'];
    $updatedAnswerD = $_POST['answerD'];
    $updatedCorrectAnswer = $_POST['correctAnswer'];

    // Update the question in the database
    $updateSql = "UPDATE questions SET 
                  question = '$updatedQuestion',
                  answerA = '$updatedAnswerA',
                  answerB = '$updatedAnswerB',
                  answerC = '$updatedAnswerC',
                  answerD = '$updatedAnswerD',
                  correctAnswer = '$updatedCorrectAnswer'
                  WHERE id = '$questionId'";
    if ($conn->query($updateSql) === TRUE) {
        echo "<script>alert('Question updated successfully.');</script>";

        header('Location: fetch_questions.php');

    } else {
        echo "Error updating question: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Exam System</title>
<!-- Add Bootstrap CSS link here -->
<link rel="icon" href="favicon.png" width="50px" type="image/x-icon">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Include your CSS styles here -->
<style>
html,
body {
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
    color: black;
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
    margin-bottom: 50px
}

/* Navbar text color */
.navbar-brand {
    color: black;
    transition: color 0.4s;
    /* Smooth transition on hover */

}

.card-body {
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
.colored,
.footer a {
    color: #ca5cdd;

}

footer a:hover,
.colored:hover {

    color: #be2ed6;
    text-decoration: underline;
}

.navbar-nav .register-btn,
.colored-btn {
    background-color: #ca5cdd;
    color: white;
    /* Adjust the value to control the button's roundness */
    transition: background-color 0.3s, color 0.4s;
    /* Smooth transition on hover */
}

.navbar-nav .register-btn {
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
    border: none;
    /* border-color: #ca5cdd; */
    box-shadow: 0 0 0 3px rgba(202, 92, 221, 0.3);
}
</style>
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
    </nav>
    
   <div class="content">

   <div class="container mt-5 ">
   <h2 class="pl-1 mb-4">Edit Question</h2>
<div class="shadow p-4">

<form method="post">
    <div class="form-group">
        <label for="question">Question:</label>
        <textarea class="form-control" id="question" name="question" rows="3"><?php echo $question; ?></textarea>
    </div>

    <div class="form-group">
        <label for="answerA">Answer A:</label>
        <input type="text" class="form-control" id="answerA" name="answerA" value="<?php echo $answerA; ?>">
    </div>

    <div class="form-group">
        <label for="answerB">Answer B:</label>
        <input type="text" class="form-control" id="answerB" name="answerB" value="<?php echo $answerB; ?>">
    </div>

    <div class="form-group">
        <label for="answerC">Answer C:</label>
        <input type="text" class="form-control" id="answerC" name="answerC" value="<?php echo $answerC; ?>">
    </div>

    <div class="form-group">
        <label for="answerD">Answer D:</label>
        <input type="text" class="form-control" id="answerD" name="answerD" value="<?php echo $answerD; ?>">
    </div>

    <div class="form-group">
        <label for="correctAnswer">Correct Answer:</label>
        <input type="text" class="form-control" id="correctAnswer" name="correctAnswer" value="<?php echo $correctAnswer; ?>">
    </div>

    <button type="submit" class="btn colored-btn">Update Question</button>
</form></div>
    </div></div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>
</html>
