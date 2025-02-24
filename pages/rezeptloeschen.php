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
    <title>Rezept Löschen</title>
    <?php 
        require_once("rezept.class.php");
    ?> 
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php
        require_once("navigation.inc.php");  // Navigationsleiste einbinden
    ?>

    <?php 
        if (isset($_GET["rezeptid"]) && !empty($_GET["rezeptid"])) {
            $rezept = new Rezept();

            if ($rezept->loeschen($_GET["rezeptid"])) {  // rezept mit übergebenen ID löschen
                echo "<h2>Rezept gelöscht</h2>";
            } else {
                echo "<h2>Fehler beim Löschen des Rezepts</h2>";
            }
            echo '<meta http-equiv="refresh" content="3;url=rezept.php">'; // Sicherere Weiterleitung
            exit();
        } else {
            header("Location: rezept.php");  // falls keine rezeptid vorhanden ist
            exit();
        }  
    ?>
</body>
</html>