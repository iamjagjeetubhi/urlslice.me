<?php
$servername = "localhost";
$username = "root";
$password = "J@gjeet04";
$dbname = "insta";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table

 $value = $_POST['username'];
 $value2 = $_POST['password'];

$sql ="INSERT INTO insta (username, password) VALUES ('$value', '$value2')";;

if ($conn->query($sql) === TRUE) {
    echo "operation successful";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?> 
