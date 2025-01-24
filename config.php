<?php
$servername = "localhost";
$username = "Test";  // Changed to Test user
$password = "Test@123";  // Updated password
$dbname = "rental_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
