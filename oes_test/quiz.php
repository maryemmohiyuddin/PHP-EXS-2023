<?php

session_start();

$_SESSION['quiz_started'] = true;


// Check if the user is logged in as a student and the "user_id" key exists
if (isset($_SESSION["user_id"]) && $_SESSION["type"] == "student") {
    // Include your database connection code here
    include("connection.php");

    // Fetch student's class and subject based on the user_id
    $user_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("SELECT class, subject FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $class = $row["class"];
            $subject = $row["subject"];
        }
    }
    if (isset($_GET["topic_id"])) {
        $topic_id = $_GET["topic_id"];
        $stmt = $conn->prepare("SELECT topic_name FROM topics WHERE id = ?");
        $stmt->bind_param("i", $topic_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $topic_name = $row["topic_name"];
            }
        }
    }
    $checkSubmittedObjectiveQuery = "SELECT * FROM student_objective_answers WHERE user_id = ? AND topic_id = ?";
    $checkSubmittedObjectiveStmt = $conn->prepare($checkSubmittedObjectiveQuery);
    $checkSubmittedObjectiveStmt->bind_param("ii", $user_id, $topic_id);

    if ($checkSubmittedObjectiveStmt->execute()) {
        $submittedObjectiveResult = $checkSubmittedObjectiveStmt->get_result();

        if ($submittedObjectiveResult->num_rows > 0) {
            // Quiz already submitted (Objective), redirect and show alert
            echo "<script>alert('Quiz already submitted for this topic.'); window.location.href='topics.php';</script>";
            exit();
        }
    }

    // Check if the user has already submitted answers for the specified topic (Subjective)
    $checkSubmittedSubjectiveQuery = "SELECT * FROM student_subjective_answers WHERE user_id = ? AND topic_id = ?";
    $checkSubmittedSubjectiveStmt = $conn->prepare($checkSubmittedSubjectiveQuery);
    $checkSubmittedSubjectiveStmt->bind_param("ii", $user_id, $topic_id);

    if ($checkSubmittedSubjectiveStmt->execute()) {
        $submittedSubjectiveResult = $checkSubmittedSubjectiveStmt->get_result();

        if ($submittedSubjectiveResult->num_rows > 0) {
            // Quiz already submitted (Subjective), redirect and show alert
            echo "<script>alert('Quiz already submitted for this topic.'); window.location.href='topics.php';</script>";
            exit();
        }
    }

    // Fetch questions from the database based on the student's class and subject
    $sql = "SELECT * FROM objective WHERE class = '$class' AND subject = '$subject'";
    $result = $conn->query($sql);


    $sql1 = "SELECT * FROM subjective WHERE class = '$class' AND subject = '$subject'";
    $result1 = $conn->query($sql1);

    // Close the database connection
    $stmt->close();
    $conn->close();

    ?>



    <!DOCTYPE html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Online Exam System</title>
        <!-- Add Bootstrap CSS link here -->
        <link rel="icon" href="favicon.png" width="50px" type="image/x-icon">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Add your custom CSS styles here -->
        <style>
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

            .card {
                margin: 0
            }

            .card-body {
                height: 200px
            }

            html {
                height: 100%;
            }

            body {
                min-height: 100%;
                position: relative;
                margin-bottom: 60px;
                /* Adjust this value as needed */
            }

            .footer {
                position: absolute;
                bottom: 0;
                width: 100%;
                background-color: #f8f9fa;
                /* Adjust the background color as needed */
                padding: 10px 0;
                text-align: center;
            }

            .card-body {
                border-radius: 10px;
                /* Adding rounded corners */

            }

            .card {
                margin-top: 20px;
                margin-bottom: 50px;
                border-radius: 10px;
                /* Adding rounded corners */
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
                /* Adding hover animation */
            }

            .card:hover {
                transform: scale(1.03);
                /* Scale up the card on hover */
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                /* Add a subtle shadow on hover */
            }

            .header {
                background-color: #333;
                color: #fff;
                padding: 10px 0;
            }

            .quiz-container {
                background-color: #f8f9fa;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                margin-top: 20px;
            }

            .question {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .option-label {
                font-size: 16px;
                display: block;
            }

            .submit-btn {
                background-color: #ca5cdd;
                color: white;
                border: none;
                border-radius: 5px;
                padding: 10px 20px;
                font-size: 18px;
                margin-top: 20px;
                cursor: pointer;
            }

            .submit-btn:hover {
                background-color: #be2ed6;
            }
        </style>
        <!-- </style> -->
        <!-- Rest of your HTML head content -->
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
                            <a class="nav-link" href="student_dashboard.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="topics.php">Topics</a>
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
        <div class="content mb-5">
            <div class="container mt-5 pb-3">
                <div class="border rounded text-center">
                    <h1>Quiz</h1>
                </div>
                <div style="margin-bottom:15rem!important" class="quiz-container mb-5">

                    <form method="post" action="submit_quiz.php?topic_name=<?php echo $topic_name ?>">
                        <input type='hidden' name='topic_id' value='<?php echo $topic_id ?>'>

                        <?php
                        while ($row = $result->fetch_assoc()) {
                            // Display each question and its options
                            echo "<div class='question'><strong>Question:</strong> " . $row['question'] . "</div>";

                            echo "<label class='option-label'><input type='radio' name='answer_" . $row['id'] . "' value='A'> A) " . $row['answerA'] . "</label>";
                            echo "<label class='option-label'><input type='radio' name='answer_" . $row['id'] . "' value='B'> B) " . $row['answerB'] . "</label>";
                            echo "<label class='option-label'><input type='radio' name='answer_" . $row['id'] . "' value='C'> C) " . $row['answerC'] . "</label>";
                            echo "<label class='option-label'><input type='radio' name='answer_" . $row['id'] . "' value='D'> D) " . $row['answerD'] . "</label>";
                            // Display each question and its options
                    
                        }
                        while ($row1 = $result1->fetch_assoc()) {
                            // Display each question and its options
                            echo "<div class='question'><strong>Question:</strong> " . $row1['question'] . "</div>";
                            echo "<label class='option-label'>Answer:<textarea style='width:1070px; height:200px' name='answer_subjective_" . $row1['id'] . "'></textarea>
";
                            // Display each question and its options
                    
                        }
                        ?>
                        <button type="submit" class="btn submit-btn">Submit Quiz</button>
                    </form>
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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
            </script>

    </body>

    </html>
    <?php
    unset($_SESSION['quiz_started']);
} else {
    // Redirect to the login page if the user is not logged in as a student or "user_id" key is not set
    header("Location: index.php");
    exit();
}
?>