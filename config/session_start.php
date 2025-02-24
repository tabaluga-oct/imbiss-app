<?php
// Startet die Session, um den Login-Status des Benutzers zu verwalten
session_start();

// Überprüft, ob der Admin angemeldet ist. Wenn nicht, wird zur Login-Seite weitergeleitet.
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../index.php"); 
    exit(); // Stoppt die weitere Ausführung, um die Weiterleitung sicherzustellen
}

// Wenn der Admin angemeldet ist, wird der Code unten fortgesetzt.
?>