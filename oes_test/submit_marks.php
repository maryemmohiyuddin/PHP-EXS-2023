<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_quiz'])) {
    include("connection.php");

    $user_id = $_POST['user_id'];
    $topic_id = $_POST['topic_id'];
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
    // 
    // Calculate Objective Marks
    $ObtainedObjectiveMarks = 0;

    if (isset($_POST['objective_answers'])) {
        $objectiveAnswers = $_POST['objective_answers'];
        // Get all question IDs
        $questionIds = array_keys($objectiveAnswers);

        // Prepare a placeholder string for the IN clause
        $placeholders = implode(',', array_fill(0, count($questionIds), '?'));

        // Fetch correct answers for all questions at once
        // Fetch correct answers for all questions at once
        $stmt = $conn->prepare("SELECT id, correctAnswer FROM objective WHERE id IN ($placeholders)");

        if (!$stmt) {
            die("Error in preparing the SQL query: " . $conn->error);
        }

        $stmt->bind_param(str_repeat('i', count($questionIds)), ...$questionIds);

        if (!$stmt->execute()) {
            die("Error executing the SQL query: " . $stmt->error);
        }

        $stmt->bind_result($questionId, $correctAnswer);

        // Dynamically bind parameters inside the loop
        foreach ($questionIds as $questionId) {
            $stmt->fetch();

            if ($objectiveAnswers[$questionId] == $correctAnswer) {
                $ObtainedObjectiveMarks += 1;
            }
        }

        $stmt->close();

    }

    // Calculate Subjective Marks
    $ObtainedSubjectiveMarks = 0;

    if (isset($_POST['marks'])) {
        $subjectiveMarks = $_POST['marks'];

        // Validate and calculate Obtained subjective marks
        foreach ($subjectiveMarks as $marks) {
            // Validate $marks if needed
            $ObtainedSubjectiveMarks += $marks;
        }
    }

    // Calculate Obtained Marks
    $ObtainedMarks = $ObtainedObjectiveMarks + $ObtainedSubjectiveMarks;
    if (isset($_POST['total_Omarks']) && isset($_POST['total_Smarks'])) {
        $totalObjectiveMarks = array_sum($_POST['total_Omarks']);


        // Calculate total marks for subjective questions
        $totalSubjectiveMarks = array_sum($_POST['total_Smarks']);


        // Calculate total marks
        $TotalMarks = $totalObjectiveMarks + $totalSubjectiveMarks;



        // Save Results to the Database
        $insertResultQuery = "INSERT INTO result (user_id, topic_id, obtained_marks, total_marks) VALUES (?, ?, ?, ?)";
        $stmtInsertResult = $conn->prepare($insertResultQuery);
        $stmtInsertResult->bind_param("iiii", $user_id, $topic_id, $ObtainedMarks, $TotalMarks);
        if ($stmtInsertResult->execute()) {
            echo "Results saved successfully!";
        } else {
            echo "Error saving results: " . $conn->error;
        }
    }


    // // Save Results to the Database
    // $insertResultQuery = "INSERT INTO result (user_id, topic_id, obtained_marks) VALUES (?, ?, ?)";
    // $stmtInsertResult = $conn->prepare($insertResultQuery);
    // $stmtInsertResult->bind_param("iii", $user_id, $topic_id, $ObtainedMarks);

    // if ($stmtInsertResult->execute()) {
    //     echo "Results saved successfully!";
    // } else {
    //     echo "Error saving results: " . $conn->error;
    // }

    // // Close the database connection
    // $stmtInsertResult->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Quiz</title>
    <!-- Add your CSS styles here -->
</head>

<body>
    <div>
        <!-- Display the result or any other information as needed -->
        <h1>Quiz Submitted</h1>
        <?php if (isset($ObtainedMarks)): ?>
            <p>Obtained Marks:
                <?php echo $ObtainedMarks; ?>
            </p>
        <?php endif; ?>
    </div>
</body>

</html>