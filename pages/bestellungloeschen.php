<?php
// session starten, um den Benutzeranmeldestatus zu überprüfen
// Session nur starten, wenn noch keine aktiv ist
if (session_status() === PHP_SESSION_NONE) {
require_once("../config/session_start.php");
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellung Löschen</title>
    <?php 
        require_once("bestellung.class.php");
    ?> 
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php
        require_once("navigation.inc.php");  // Navigationsleiste einbinden
    ?>

    <?php
        $id = $_GET["bestellungid"];
        if (isset($id) && !empty($id)) {
        $bestellung = new Bestellung();

            if ($bestellung->loeschen($id)) {  // Bestellung mit übergebenen ID löschen
                echo "<h2>Bestellung gelöscht</h2>";
            } else {
                echo "<h2>Fehler beim Löschen der Bestellung</h2>";
            }
            echo '<meta http-equiv="refresh" content="3;url=bestellung.php">'; // Sicherere Weiterleitung
            exit();
       } else {
        header("Location: bestellung.php");  // falls keine Bestellung vorhanden ist
        exit();
       }
    ?>
</body>
</html>
