<?php
$mysqli = new mysqli("127.0.0.1", "root", "remruata@321#", "runmawi", 3306);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    echo "MySQL connection successful!";
}
?>
