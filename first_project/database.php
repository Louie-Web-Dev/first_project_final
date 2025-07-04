<?php
$hostName   = "localhost";
$dbUser     = "root";
$dbPassword = "";
$dbName     = "first_project_db";

$conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
