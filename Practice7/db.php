<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "testdb"; //Require to create DBCS

// Setting the connection
$conn = new mysqli($servername, $username, $password, $database);

// Checking the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}