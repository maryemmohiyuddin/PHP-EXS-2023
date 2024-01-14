<?php
include("connection.php"); // Include your database connection code

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $marks = $_POST['marks'];
    $subject = $_POST['subject'];
    $class = $_POST['class'];
    $topic_id = $_POST['topic']; // Assuming you have a select element for topic selection
    $question = $_POST['question'];
    $answerA = $_POST['answerA'];
    $answerB = $_POST['answerB'];
    $answerC = $_POST['answerC'];
    $answerD = $_POST['answerD'];
    $correctAnswer = $_POST['correctAnswer'];

    // Insert the question, answers, and topic into your database
    $sql = "INSERT INTO objective (subject, class, topic_id, question, answerA, answerB, answerC, answerD, correctAnswer, marks)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssssss", $subject, $class, $topic_id, $question, $answerA, $answerB, $answerC, $answerD, $correctAnswer, $marks);

    if ($stmt->execute()) {
        // Question added successfully
        header("Location: add_question.php"); // Redirect to a page showing the list of questions
        exit();
    } else {
        // Error handling
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>