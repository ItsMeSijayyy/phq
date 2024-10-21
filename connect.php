<?php
// Database connection
$servername = "localhost"; 
$username = "root";         
$password = "";             
$dbname = "_Mindsoothe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo "Failed to connect DB".$conn->connect_error;
}
?>