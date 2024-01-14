<?php
session_start();

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

    // Fetch objective questions and correct answers from the database based on the student's class and subject
    $sqlObjective = "SELECT id, correctAnswer FROM objective WHERE class = ? AND subject = ?";
    $stmtObjective = $conn->prepare($sqlObjective);
    $stmtObjective->bind_param("ss", $class, $subject);
    $topic_id = $_POST['topic_id'];


    if ($stmtObjective->execute()) {
        $resultObjective = $stmtObjective->get_result();

        // Initialize variables for calculating results
        $totalQuestionsObjective = 0;
        $correctAnswersObjective = 0;

        // Loop through submitted objective answers and check correctness
        while ($row = $resultObjective->fetch_assoc()) {
            $questionId = $row['id'];
            $correctAnswer = $row['correctAnswer'];

            // Check if an answer was submitted for this question
            if (isset($_POST['answer_' . $questionId])) {
                $submittedAnswer = $_POST['answer_' . $questionId];

                // Compare submitted answer with the correct answer
                if ($submittedAnswer === $correctAnswer) {
                    $correctAnswersObjective++;
                }

                // Save the student's objective answer to the database
                $insertObjectiveAnswerSQL = "INSERT INTO student_objective_answers (user_id, question_id, answer_text,  topic_id) VALUES (?, ?, ?, ?)";
                $stmtInsertObjectiveAnswer = $conn->prepare($insertObjectiveAnswerSQL);
                $stmtInsertObjectiveAnswer->bind_param("iiss", $user_id, $questionId, $submittedAnswer, $topic_id);
                $stmtInsertObjectiveAnswer->execute();
            }

            $totalQuestionsObjective++;
        }

        // Close the objective questions database connection
        $stmtObjective->close();

        // Fetch subjective questions from the database based on the student's class and subject
        $sqlSubjective = "SELECT id FROM subjective WHERE class = ? AND subject = ?";
        $stmtSubjective = $conn->prepare($sqlSubjective);
        $stmtSubjective->bind_param("ss", $class, $subject);

        if ($stmtSubjective->execute()) {
            $resultSubjective = $stmtSubjective->get_result();

            // Loop through subjective questions and save the student's answers
            while ($row = $resultSubjective->fetch_assoc()) {

                $questionIdSubjective = $row['id'];

                // Check if an answer was submitted for this subjective question
                if (isset($_POST['answer_subjective_' . $questionIdSubjective])) {
                    $submittedAnswerSubjective = $_POST['answer_subjective_' . $questionIdSubjective];

                    // Save the student's subjective answer to the database
                    $insertSubjectiveAnswerSQL = "INSERT INTO student_subjective_answers (user_id, question_id, answer_text, topic_id) VALUES (?, ?, ?,?)";
                    $stmtInsertSubjectiveAnswer = $conn->prepare($insertSubjectiveAnswerSQL);
                    $stmtInsertSubjectiveAnswer->bind_param("iiss", $user_id, $questionIdSubjective, $submittedAnswerSubjective, $topic_id);
                    $stmtInsertSubjectiveAnswer->execute();
                }

            }

            // Close the subjective questions database connection
            $stmtSubjective->close();
        }

        // Calculate the objective score
        $scoreObjective = ($correctAnswersObjective / $totalQuestionsObjective) * 100;

        // Close the main database connection
        $conn->close();
        header("Location: quiz_submitted.php");

    }
    ?>


    </html>

    <?php
} else {
    // Redirect to the login page if the user is not logged in as a student or "user_id" key is not set
    header("Location: index.php");
    exit();
}
?>