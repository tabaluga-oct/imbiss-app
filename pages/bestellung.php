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
    <title>Bestellung ausgeben</title>
    <?php 
        require_once("bestellung.class.php");
    ?>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php 
        require_once("navigation.inc.php");
    ?>

    <h3>Bestellungen</h3>
    <div class="ausgabe">
        <?php 
            $bestellung = new Bestellung();
            $bestellung->lesenAlleDaten();
        ?>
    </div>
    <div class="button-container">
        <a class="button" href="bestellungbearbeiten.php">Neue Bestellung anlegen</a>
    </div>
</body>
</html>