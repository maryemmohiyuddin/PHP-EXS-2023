<?php
include("connection.php");

// Check if the question ID is provided in the POST data
if (isset($_POST['questionId'])) {
    $questionId = $_POST['questionId'];

    // Delete the question from the database
    $deleteSql = "DELETE FROM questions WHERE id = '$questionId'";
    if ($conn->query($deleteSql) === TRUE) {
        header("Location: fetch_questions.php");

    } else {
        echo "Error deleting question: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Question ID not provided.";
}
?>
