<?php
session_start();

// Check if the user is logged in as a student and the "user_id" key exists
if (isset($_SESSION["user_id"]) && $_SESSION["type"] == "student") {
    // Student is logged in, so you can proceed with displaying the topics

    // Include your database connection code here
    include("connection.php");

    // Fetch student's data from the database based on the user_id
    $user_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("SELECT full_name, class, subject FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $full_name = $row["full_name"];
            $student_class = $row["class"];
            $student_subject = $row["subject"];
        }
    }

    // Close the database connection
    $stmt->close();

    // Query the database to fetch topics and count the number of questions for each topic
    $topics = []; // An array to store the fetched topics

    $stmt = $conn->prepare("SELECT t.id, t.topic_name, 
                               COUNT(o.id) AS num_objective_questions,
                               COUNT(s.id) AS num_subjective_questions
                        FROM topics t
                        LEFT JOIN objective o ON t.id = o.topic_id AND o.class = ? AND o.subject = ?
                        LEFT JOIN subjective s ON t.id = s.topic_id AND s.class = ? AND s.subject = ?
                        WHERE t.class = ? AND t.subject = ?
                        GROUP BY t.id, t.topic_name");

    $stmt->bind_param("ssssss", $student_class, $student_subject, $student_class, $student_subject, $student_class, $student_subject);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $topic_id = $row["id"];
            $topic_name = $row["topic_name"];
            $num_objective_questions = $row["num_objective_questions"];
            $num_subjective_questions = $row["num_subjective_questions"];

            $topics[] = [
                "topic_id" => $topic_id,
                "topic_name" => $topic_name,
                "num_objective_questions" => $num_objective_questions,
                "num_subjective_questions" => $num_subjective_questions

            ];
        }
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    ?>


    <!DOCTYPE html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Online Exam System</title>
        <!-- Add Bootstrap CSS link here -->
        <link rel="icon" href="favicon.png" width="50px" type="image/x-icon">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Add your custom CSS styles here -->
        <style>
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

            .card {
                margin: 0
            }

            .card-body {
                height: 200px
            }

            html {
                height: 100%;
            }

            body {
                min-height: 100%;
                position: relative;
                margin-bottom: 60px;
                /* Adjust this value as needed */
            }

            .footer {
                position: absolute;
                bottom: 0;
                width: 100%;
                background-color: #f8f9fa;
                /* Adjust the background color as needed */
                padding: 10px 0;
                text-align: center;
            }

            .card-body {
                border-radius: 10px;
                /* Adding rounded corners */

            }

            .card {
                margin-top: 20px;
                margin-bottom: 50px;
                border-radius: 10px;
                /* Adding rounded corners */
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
                /* Adding hover animation */
            }

            .card:hover {
                transform: scale(1.03);
                /* Scale up the card on hover */
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                /* Add a subtle shadow on hover */
            }
        </style>
        <!-- </style> -->
        <!-- Rest of your HTML head content -->
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
                            <a class="nav-link" href="student_dashboard.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="topics.php">Topics</a>
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
        <div class="content">
            <div class="container mt-5">
                <h2>Topics for
                    <?php echo $student_class; ?>th -
                    <?php echo $student_subject; ?>
                </h2>

                <!-- Replace your current list with this ordered list -->
                <ol class="list-group list-group-numbered">
                    <?php
                    // Display the fetched topics and buttons
                    foreach ($topics as $topic) {
                        $topic_id = $topic["topic_id"];
                        $topic_name = $topic["topic_name"];
                        $num_objective_questions = $topic["num_objective_questions"];
                        $num_subjective_questions = $topic["num_subjective_questions"];
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="font-weight-bold">
                                    <?php echo $topic_name; ?>
                                </div>
                                <?php echo "Objective Questions: $num_objective_questions, Subjective Questions: $num_subjective_questions"; ?>
                            </div>
                            <?php if ($num_objective_questions + $num_subjective_questions > 0) { ?>
                                <a href="quiz.php?topic_id=<?php echo $topic_id; ?>" class="btn colored-btn">Go to Quiz</a>
                            <?php } ?>
                        </li>
                        <?php
                    }

                    ?>
                </ol>


                <!-- Add the rest of your HTML content here -->
            </div>
        </div>

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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
            </script>

    </body>

    </html>

    <?php
} else {
    // Redirect to the login page if the user is not logged in as a student or "user_id" key is not set
    header("Location: index.php");
    exit();
}
?>