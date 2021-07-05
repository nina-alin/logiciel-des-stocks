<?php
// Initialiser la session
session_start();

// Détruire la session.
if (session_destroy()) {
  header("Location: https://ent.crous-lille.fr/home.php");
  // Redirection vers la page de connexion
  // header("Location: ../login.php");
}
