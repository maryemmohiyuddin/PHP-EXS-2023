<?php
include("connection.php"); // Include your database connection code

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $subject = $_POST['subject'];
    $class = $_POST['class'];
    $topic_id = $_POST['topic']; // Assuming you have a select element for topic selection
    $question = $_POST['question'];
    $marks = $_POST['marks'];



    // Insert the question, answers, and topic into your database
    $sql = "INSERT INTO subjective (subject, class, topic_id, question, marks)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $subject, $class, $topic_id, $question, $marks);

    if ($stmt->execute()) {
        // Question added successfully
        header("Location: add_Subjective.php"); // Redirect to a page showing the list of questions
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