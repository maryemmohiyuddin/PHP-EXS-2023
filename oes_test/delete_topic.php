<?php
include("connection.php");

// Check if the topic ID is provided in the POST data
if (isset($_POST['topicId'])) {
    $topicId = $_POST['topicId'];

    // Delete associated records in the `objective` table first
    $deleteObjectiveSql = "DELETE FROM objective WHERE topic_id = '$topicId'";

    if ($conn->query($deleteObjectiveSql) === TRUE) {
        // Delete associated records in the `subjective` table
        $deleteSubjectiveSql = "DELETE FROM subjective WHERE topic_id = '$topicId'";

        if ($conn->query($deleteSubjectiveSql) === TRUE) {
            // Now, delete the topic from the `topics` table
            $deleteTopicSql = "DELETE FROM topics WHERE id = '$topicId'";

            if ($conn->query($deleteTopicSql) === TRUE) {
                header("Location: get_topics.php");
            } else {
                echo "Error deleting topic: " . $conn->error;
            }
        } else {
            echo "Error deleting associated subjective records: " . $conn->error;
        }
    } else {
        echo "Error deleting associated objective records: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Topic ID not provided.";
}
?>