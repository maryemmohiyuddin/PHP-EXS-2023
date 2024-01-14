<?php

session_start();
$_SESSION["subject"] = $_POST["subject"];
$_SESSION["class"] = $_POST["class"];

header('Location: get_topics.php');



?>