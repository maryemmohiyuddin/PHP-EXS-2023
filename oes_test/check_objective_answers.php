<?php
session_start();

// Include your database connection code here
include("connection.php");

// Check if the user is logged in as an admin
if (isset($_SESSION["user_id"]) && $_SESSION["type"] == "admin") {
    // Check if user_id and topic_id are provided in the URL
    if (isset($_GET["user_id"]) && isset($_GET["topic_id"])) {
        $user_id = $_GET["user_id"];
        $topic_id = $_GET["topic_id"];

        // Fetch student details
        $studentQuery = "SELECT full_name FROM users WHERE id = ?";
        $stmt = $conn->prepare($studentQuery);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            $studentResult = $stmt->get_result();
            if ($studentResult->num_rows === 1) {
                $studentRow = $studentResult->fetch_assoc();
                $student_name = $studentRow['full_name'];

                // Fetch objective answers
                $answersQuery = "SELECT o.question, o.correctAnswer, soa.answer_text
                    FROM objective o
                    JOIN student_objective_answers soa ON o.id = soa.question_id
                    WHERE soa.user_id = ? AND soa.topic_id = ?";

                $stmt = $conn->prepare($answersQuery);
                $stmt->bind_param("ii", $user_id, $topic_id);

                if ($stmt->execute()) {
                    $answersResult = $stmt->get_result();

                    ?>
                    <!DOCTYPE html>
                    <html lang="en">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Check Objective Answers</title>
                        <!-- Add Bootstrap CSS link here -->
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                        <style>
                            /* Add your custom styles here */
                        </style>
                    </head>

                    <body>
                        <div class="container mt-5">
                            <h1>Check Objective Answers</h1>
                            <h3>Student:
                                <?php echo $student_name; ?> - Topic ID:
                                <?php echo $topic_id; ?>
                            </h3>

                            <?php if ($answersResult->num_rows > 0) { ?>
                                <!-- Display objective answers -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Correct Answer</th>
                                            <th>Student's Answer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($answerRow = $answersResult->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>{$answerRow['question']}</td>";
                                            echo "<td>{$answerRow['correctAnswer']}</td>";
                                            echo "<td>{$answerRow['answer_text']}</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <p>No objective answers found for this student.</p>
                            <?php } ?>
                        </div>

                        <!-- Add Bootstrap JS and jQuery links here -->
                        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
                    </body>

                    </html>
                    <?php

                } else {
                    echo "Error fetching objective answers: " . $conn->error;
                }
            } else {
                echo "Student not found.";
            }
        } else {
            echo "Error fetching student details: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "User ID or Topic ID is not provided in the URL.";
    }
} else {
    // Redirect to the login page if the user is not logged in as an admin or "user_id" key is not set
    header("Location: index.php");
    exit();
}
?>