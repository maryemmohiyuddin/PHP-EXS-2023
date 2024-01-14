<?php

session_start();
$_SESSION["subject"]=$_POST["subject1"];
$_SESSION["class"]=$_POST["class1"];
$_SESSION["topic"]=$_POST["topic"];

header('Location: fetch_questions.php');



?>