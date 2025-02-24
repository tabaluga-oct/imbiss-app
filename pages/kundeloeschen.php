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
    <title>Kunde löschen</title>
    <?php 
        require_once("kunde.class.php");  // Kunde_klasse einbinden
    ?>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php 
        require_once("navigation.inc.php");  // Navi einbinden
    ?>

    <?php 
        if (isset($_GET["kundeid"]) && !empty($_GET["kundeid"])) {
            $kunde = new Kunde();

            if ($kunde->loeschen($_GET["kundeid"])) {  // Kunde mit übergebenen ID löschen
                echo "<h2>Kunde gelöscht</h2>";
            } else {
                echo "<h2>Fehler beim Löschen des Kunden</h2>";
            }
            echo '<meta http-equiv="refresh" content="3;url=kunde.php">'; // Sicherere Weiterleitung
            exit();
        } else {
            header("Location: kunde.php");  // falls keine kundeid vorhanden ist
            exit();
        }  
    ?>
</body>
</html>