<?php

session_start();
$_SESSION["subject"] = $_POST["subject2"];
$_SESSION["class"] = $_POST["class2"];
$_SESSION["topic"] = $_POST["topic"];



// header('Location: add_question.php');



?>
<?php
include("connection.php");
// session_start();
if (isset($_SESSION["user_id"]) && $_SESSION["type"] === "admin") {
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Exam System</title>
    <link rel="icon" href="favicon.png" width="50px" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

    .navbar .navbar-brand img {
        width: 40px;
        margin-right: 10px;
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

    .navbar-brand {
        color: black;
        transition: color 0.4s;
    }

    .card-body {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .navbar-nav .nav-link {
        color: black;
        transition: color 0.4s;
    }

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
        transition: background-color 0.3s, color 0.4s;
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
        border: none;
        box-shadow: 0 0 0 3px rgba(202, 92, 221, 0.3);
    }

    .form-container {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .form-label {
        font-weight: bold;
        margin-top: 10px;
    }

    .form-control {
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
    }

    .submit-button {
        background-color: #ca5cdd;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .submit-button:hover {
        background-color: #be2ed6;
    }

    .list-group-item-action:focus {
        outline: none;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="favicon.png" alt="Icon">
            </a>
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
                        <a class="nav-link register-btn" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="content">
        <div class="container mt-5">
            <h2 class="mb-4">Question type</h2>
        </div>
        <div class="container">
            <div class="row">
                <a href="add_Question.php"> <button type="button" class="btn btn-primary px-5">Objective</button></a>
                &nbsp&nbsp&nbsp&nbsp
                <a href="add_Subjective.php"> <button type="button" class="btn btn-primary px-5">Subjective</button></a>


            </div>
        </div>
        <script>
        function toggleForm(formId) {
            var forms = document.querySelectorAll('.collapse');
            for (var i = 0; i < forms.length; i++) {
                forms[i].classList.remove('show');
            }
            document.getElementById(formId).classList.add('show');
        }
        </script>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
    const viewQuizButton = document.getElementById("viewQuizButton");
    const addQuizButton = document.getElementById("addQuizButton");
    const viewQuizForm = document.getElementById("Viewquiz");
    const addQuizForm = document.getElementById("addquiz");

    viewQuizButton.addEventListener("click", () => {
        if (addQuizForm.style.display === "block") {
            addQuizForm.style.display = "none";
        }
        if (viewQuizForm.style.display === "none") {
            viewQuizForm.style.display = "block";
        } else {
            viewQuizForm.style.display = "none";
        }
    });

    addQuizButton.addEventListener("click", () => {
        if (viewQuizForm.style.display === "block") {
            viewQuizForm.style.display = "none";
        }
        if (addQuizForm.style.display === "none") {
            addQuizForm.style.display = "block";
        } else {
            addQuizForm.style.display = "none";
        }
    });
    </script>
    <script>
    const addButton = document.getElementById("addButton");
    const addForm = document.getElementById("addForm");

    addButton.addEventListener("click", () => {
        if (addForm.style.display === "none") {
            addForm.style.display = "block";
        } else {
            addForm.style.display = "none";
        }
    });
    </script>
    <script>
    document.getElementById("viewButton").addEventListener("click", function() {
        document.getElementById("inputForm").style.display = "block";
    });
    </script>
</body>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>

</html>
</body>

</html>