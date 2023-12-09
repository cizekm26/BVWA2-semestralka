<?php

// Database connection parameters
$servername = "localhost";  // Change this to your MySQL server
$username = "root";         // Change this to your MySQL username
$password = "";             // Change this to your MySQL password
$dbname = "semestralni_prace";  // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>