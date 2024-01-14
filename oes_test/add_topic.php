<?php
include("connection.php"); // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $topicName = $_POST['topicName'];

    // Perform validation here if needed

    // Insert the topic into the database
    $insertSql = "INSERT INTO topics (class, subject, topic_name) VALUES ('$class', '$subject', '$topicName')";

    if ($conn->query($insertSql) === TRUE) {
        echo "<script>alert('Topic added suucessfully');</script>";
        echo "<script>setTimeout(function(){ window.location = 'manage_topics_questions.php'; });</script>"; // Redirect after 3 seconds
    } else {
        echo "<script>alert('Error adding topic');</script>";
        echo "<script>setTimeout(function(){ window.location = 'manage_topics_questions.php'; });</script>"; // Redirect after 3 seconds
    }

    $conn->close();
} else {
    // Handle the case when the form is not submitted
    echo "Form not submitted.";
}
?>