<?php
// Initialiser la session
session_start();

// Détruire la session 
if (session_destroy()) {
  header("Location: https://ent.crous-lille.fr/home.php"); // on redirige vers l'ENT
}
