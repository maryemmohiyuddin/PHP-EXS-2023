<?php 
session_start();

?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Exam System</title>
<!-- Add Bootstrap CSS link here -->
<link rel="icon" href="favicon.png" width="50px" type="image/x-icon">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Include your CSS styles here -->
<style>
html,
body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
}

.content {
    flex-grow: 1;
}

.footer {
    background-color: #f8f9fa;
    padding: 10px 0;
    text-align: center;
}

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
</style>
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
                        <a class="nav-link" href="admin_dashboard.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Students
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="admin_dashboard.php?action=manage_students">Requests</a>
                            </li>
                            <li><a class="dropdown-item" href="view_student_credentials.php">Credentials</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_topics_questions.php">Quizzes</a>
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
    <div class="container">
        <h2 class="mt-5 mb-4">Question List</h2>
        <?php
        include("connection.php");

        // Check if form is submitted
        // Get class and subject from the form
        $class = $_SESSION['class'];
        $subject = $_SESSION['subject'];
        $topic_id = $_SESSION['topic'];


        // Fetch questions from the database for the specified class and subject
        $sql = "SELECT * FROM questions WHERE class = '$class' AND subject = '$subject' AND topic_id = '$topic_id'";
        $result = $conn->query($sql); 

        // Display the fetched questions in a Bootstrap table
        if ($result->num_rows > 0) {
            echo '<table class="table table-striped table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Question</th>';
            echo '<th>Answer A</th>';
            echo '<th>Answer B</th>';
            echo '<th>Answer C</th>';
            echo '<th>Answer D</th>';
            echo '<th>Correct Answer</th>';
            echo '<th>Edit</th>';
            echo '<th>Delete</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['question'] . '</td>';
                echo '<td>' . $row['answerA'] . '</td>';
                echo '<td>' . $row['answerB'] . '</td>';
                echo '<td>' . $row['answerC'] . '</td>';
                echo '<td>' . $row['answerD'] . '</td>';
                echo '<td>' . $row['correctAnswer'] . '</td>';
                echo '<td><a href="edit_question.php?id=' . $row['id'] . '" class="btn btn-success">Edit</a></td>';
                echo '<td><a href="#" onclick="confirmDelete(' . $row['id'] . ');" class="btn btn-danger">Delete</a></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo "No questions found for the specified class and subject.";
        }

        $conn->close();
        ?>
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


    <!-- Add Bootstrap and jQuery JS scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
    function confirmDelete(questionId) {
        var confirmation = confirm("Are you sure you want to delete this question?");
        if (confirmation) {
            // User clicked "OK" (Yes)
            // Submit a form to delete the question
            var form = document.createElement('form');
            form.method = 'post';
            form.action = 'delete_question.php'; // Replace with the actual delete script
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'questionId';
            input.value = questionId;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        } else {
            // User clicked "Cancel"
            // Do nothing
        }
    }
    </script>
</body>