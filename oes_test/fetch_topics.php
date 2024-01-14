<?php
// Include your database connection code here
include("connection.php");

if (isset($_GET["class"]) && isset($_GET["subject"])) {
    $class = $_GET["class"];
    $subject = $_GET["subject"];
        // Query the database to fetch topics based on the selected class and subject
    $sql = "SELECT * FROM `topics` WHERE `class` = '$class' AND `subject` = '$subject'";
    $result = mysqli_query($conn, $sql);

    $topics = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $topics[] = [
            "id" => $row["id"],
            "topic_name" => $row["topic_name"]
        ];
    }

    // Return topics as JSON
    echo json_encode($topics);
}
?>
