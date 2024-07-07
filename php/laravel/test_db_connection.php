<?php
$servername = getenv('DB_HOST') ?: 'mysql';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: 'master';
$dbname = getenv('DB_DATABASE') ?: 'poc_db';
$port = getenv('DB_PORT') ?: 3310;



echo "Trying to connect to MySQL server at $servername on port $port with username $username\n";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to the database.";
?>
