<?php

$conn = new mysqli("localhost", "root", "", "oes_test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>