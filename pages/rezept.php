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
    <title>Rezeptliste ausgeben</title>
    <?php 
        require_once("rezept.class.php");
    ?>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php 
        require_once("navigation.inc.php");
    ?>

    <h3>Rezeptliste</h3>
    <div class="ausgabe">
        <?php 
            $rezept = new Rezept();
            $rezept->lesenAlleDaten();
        ?>
    </div>
    <div class="button-container">
        <a class="button" href="rezeptbearbeiten.php">Neues Rezept anlegen</a>
    </div>
</body>
</html>