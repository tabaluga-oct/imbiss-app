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
    <title>Gekochtes Gericht Löschen</title>
    <?php 
        require_once("gekochtes.class.php");
    ?> 
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php
        require_once("navigation.inc.php");  // Navigationsleiste einbinden
    ?>

    <?php
        $id = $_GET["gekochtesgerichtid"];
        if (isset($id) && !empty($id)) {
        $gekochtes = new Gekochtes();

            if ($gekochtes->loeschen($id)) {  // Gericht mit übergebenen ID löschen
                echo "<h2>Gekochtes Gericht gelöscht</h2>";
            } else {
                echo "<h2>Fehler beim Löschen des Gerichts</h2>";
            }
            echo '<meta http-equiv="refresh" content="3;url=gekochtesgericht.php">'; // Sicherere Weiterleitung
            exit();
       } else {
        header("Location: gekochtesgericht.php");  // falls kein Gericht vorhanden ist
        exit();
       }
    ?>
</body>
</html>
