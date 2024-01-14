<?php

session_start();

// Check if the user is logged in as a student and the "user_id" key exists
// Include your database connection code here
include("connection.php");

$topic_id = $_GET['topic_id'];
$user_id = $_GET['user_id'];
$checkResultQuery = "SELECT id FROM result WHERE user_id = ? AND topic_id = ?";
$stmtCheckResult = $conn->prepare($checkResultQuery);
$stmtCheckResult->bind_param("ii", $user_id, $topic_id);
$stmtCheckResult->execute();
$stmtCheckResult->store_result();

if ($stmtCheckResult->num_rows > 0) {
    echo "Result for this user and topic already published!";
    $stmtCheckResult->close();
    $conn->close();
    exit; // Terminate the script if the result already exists
}

$stmtCheckResult->close();
// Fetch objective questions and answers
$objectiveQuery = "SELECT id, question, answerA, answerB, answerC, answerD, marks FROM objective WHERE topic_id = ?";
$stmtObjective = $conn->prepare($objectiveQuery);
$stmtObjective->bind_param("i", $topic_id);

if ($stmtObjective->execute()) {
    $objectiveResult = $stmtObjective->get_result();
} else {
    echo "Error fetching objective questions: " . $conn->error;
}

// Fetch subjective questions
$subjectiveQuery = "SELECT id, question, marks FROM subjective WHERE topic_id = ?";
$stmtSubjective = $conn->prepare($subjectiveQuery);
$stmtSubjective->bind_param("i", $topic_id);

if ($stmtSubjective->execute()) {
    $subjectiveResult = $stmtSubjective->get_result();
} else {
    echo "Error fetching subjective questions: " . $conn->error;
}

// Fetch student's answers (assuming they are stored in the database)
$studentAnswersQuery = "SELECT question_id, answer_text FROM student_objective_answers WHERE user_id = ?";
$stmtStudentAnswers = $conn->prepare($studentAnswersQuery);
$stmtStudentAnswers->bind_param("i", $user_id);

if ($stmtStudentAnswers->execute()) {
    $studentAnswersResult = $stmtStudentAnswers->get_result();
    $studentAnswers = [];

    while ($row = $studentAnswersResult->fetch_assoc()) {
        $studentAnswers[$row['question_id']] = $row['answer_text'];
    }
} else {
    echo "Error fetching student answers: " . $conn->error;
}
$studentSubAnswersQuery = "SELECT question_id, answer_text FROM student_subjective_answers WHERE user_id = ?";
$stmtSubStudentAnswers = $conn->prepare($studentSubAnswersQuery);
$stmtSubStudentAnswers->bind_param("i", $user_id);

if ($stmtSubStudentAnswers->execute()) {
    $studentSubAnswersResult = $stmtSubStudentAnswers->get_result();
    $studentSubAnswers = [];

    while ($row = $studentSubAnswersResult->fetch_assoc()) {
        $studentSubAnswers[$row['question_id']] = $row['answer_text'];
    }
} else {
    echo "Error fetching student answers: " . $conn->error;
}

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
    </nav>
    <!-- Your navigation bar -->

    <div class="content mb-5">
        <div class="container mt-5 pb-3">
            <div class="border rounded text-center">
                <h1>Quiz</h1>
            </div>

            <!-- Display Objective Questions and Input Fields -->
            <?php if ($objectiveResult->num_rows > 0) { ?>
            <h2>Objective Questions</h2>
            <form method="post" action="submit_marks.php">
                <input type="hidden" name="topic_id" value="<?php echo $topic_id ?>">
                <input type="hidden" name="user_id" value="<?php echo $user_id ?>">


                <?php while ($rowObjective = $objectiveResult->fetch_assoc()) { ?>
                <div class="question">
                    <b>
                        <p>Marks: <?php echo $rowObjective['marks']; ?>
                    </b>


                    <b>
                        <p>Question:
                    </b><?php echo $rowObjective['question']; ?></p>
                    </p>

                    <div>
                        <?php $questionId = $rowObjective['id']; ?>
                        <input type="hidden" name="total_Omarks[<?php echo $questionId; ?>]"
                            value="<?php echo $rowObjective['marks'] ?>">

                        <label>
                            <input type="radio" name="objective_answers[<?php echo $questionId; ?>]" value="A"
                                <?php echo ($studentAnswers[$questionId] == 'A') ? 'checked' : ''; ?> readonly>
                            <?php echo $rowObjective['answerA']; ?>
                        </label><br>
                        <label>
                            <input type="radio" name="objective_answers[<?php echo $questionId; ?>]" value="B"
                                <?php echo ($studentAnswers[$questionId] == 'B') ? 'checked' : ''; ?> readonly>
                            <?php echo $rowObjective['answerB']; ?>
                        </label><br>
                        <label>
                            <input type="radio" name="objective_answers[<?php echo $questionId; ?>]" value="C"
                                <?php echo ($studentAnswers[$questionId] == 'C') ? 'checked' : ''; ?> readonly>
                            <?php echo $rowObjective['answerC']; ?>
                        </label><br>
                        <label>
                            <input type="radio" name="objective_answers[<?php echo $questionId; ?>]" value="D"
                                <?php echo ($studentAnswers[$questionId] == 'D') ? 'checked' : ''; ?> readonly>
                            <?php echo $rowObjective['answerD']; ?>
                        </label>
                    </div>
                </div>
                <?php } ?>
                <?php } else {
    echo "<p>No objective questions available for this quiz.</p>";
} ?>

                <!-- Display Subjective Questions and Input Fields -->
                <?php if ($subjectiveResult->num_rows > 0) { ?>
                <h2>Subjective Questions</h2>
                <?php while ($rowSubjective = $subjectiveResult->fetch_assoc()) { ?>
                <div class="question">
                    <input type="hidden" name="total_Smarks[<?php echo $rowSubjective['id'];?>]"
                        value="<?php echo $rowSubjective['marks'] ?>">

                    <b>
                        <p>Marks: <input type="text" name="marks[<?php echo $rowSubjective['id']; ?>]">
                            /<?php echo $rowSubjective['marks']; ?>
                        </p>
                    </b>
                    <b>
                        <p>Question:
                    </b> <?php echo $rowSubjective['question']; ?></p>
                    <?php $subjectiveQuestionId = $rowSubjective['id']; ?>
                    <b>
                        <p>Answer:</p>
                    </b>
                    <input type="text" name="subjective_answers[<?php echo $subjectiveQuestionId; ?>]"
                        value="<?php echo isset($studentSubAnswers[$subjectiveQuestionId]) ? $studentSubAnswers[$subjectiveQuestionId] : ''; ?>"
                        readonly>
                </div><br>
                <button type="submit" name="submit_quiz" class="btn submit-btn btn-primary">Submit Quiz</button>
                <?php } ?>
            </form>
            <?php } else {
    echo "<p>No subjective questions available for this quiz.</p>";
} ?>
            <br>
            <!-- Submit Button -->
            <!-- Submit Button -->


            <!-- Your footer section -->

            <!-- Your scripts -->
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
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous">
            </script>

            <!-- Add Bootstrap and jQuery JS scripts here -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>

</body>

</html>