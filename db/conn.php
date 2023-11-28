<?php

$hostName = "localhost";
$userName = "root";
$password = "";
$database_name = "export_csv_demo";

$conn = mysqli_connect($hostName, $userName, $password, $database_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully";
}
