<?php

// les identifiants de connexion
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stocks";

// se connecter
$conn = mysqli_connect($servername, $username, $password, $dbname);

//  Changer l'encodage des caractères en utf8
mysqli_set_charset($conn, "utf8");

// Si la connexion échoue
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
