<?php 
// Datenbank Verbindungsdetails
$host = "localhost";
$user = "root";
$passwort = "";
$db = "imbissverwaltung";

// Datenbank Verbindung erstellen
$mysqli = new mysqli($host, $user, $passwort, $db);

// Verbindung überprüfen
if ($mysqli->connect_error) {
    die("Fehler beim Verbinden: " . $mysqli->connect_error);
}
?>
