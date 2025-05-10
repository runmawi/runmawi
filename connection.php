<?php
date_default_timezone_set("Asia/Kolkata");
$servername = "localhost"; // Change this to your database server (e.g., 127.0.0.1 or your domain)
$username = "runmawi_noa"; // Replace with your phpMyAdmin username
$password = "Nanoa123@#$"; // Replace with your phpMyAdmin password
$dbname = "runmawi_vod"; // Replace with your database name (optional, can be empty if not checking a specific DB)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully to the database.";


?>
