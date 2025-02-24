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
    <title>Kundenliste ausgeben</title>
    <?php 
        require_once("kunde.class.php");  // Koch-Klasse einbinden.
    ?>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php 
        require_once("navigation.inc.php");  // Navigationsleiste einbinden. 
    ?>

    <h3>Kundenliste</h3>
    <div class="ausgabe">
        <?php 
            $kunde = new Kunde();
            $kunde->lesenAlleDaten();
        ?>
    </div>
    <div class="button-container">
        <a class="button" href="kundebearbeiten.php">Neue Kunde anlegen</a>
        <a class="button" href="kundesuchen.php">Kunde suchen</a>
    </div>
</body>
</html>