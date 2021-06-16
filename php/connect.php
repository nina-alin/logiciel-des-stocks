<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stocks";
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Change character set to utf8
mysqli_set_charset($conn, "utf8");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
