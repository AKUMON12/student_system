<?php
$host = "db";
$port = 3307;
$username = "root";
$password = "Anyaforger_290034";
$database = "student_system";

// Create a connection
$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>