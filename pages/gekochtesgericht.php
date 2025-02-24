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
    <title>Gekochtes Gerichte</title>
    <?php 
        require_once("gekochtes.class.php");
    ?>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php 
        require_once("navigation.inc.php");
    ?>

    <h3>Gekochtes Gerichte</h3>
    <div class="ausgabe">
        <?php 
            $gekochtes = new Gekochtes();
            $gekochtes->lesenAlleDaten();
        ?>
    </div>
    <div class="button-container">
        <a class="button" href="gekochtesbearbeiten.php">Neues Gekochtes Gericht anlegen</a>
    </div>
</body>
</html>