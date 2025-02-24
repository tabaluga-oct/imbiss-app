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
    <title>Koch Löschen</title>
    <?php 
        require_once("koch.class.php");
    ?> 
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php
        require_once("navigation.inc.php");  // Navigationsleiste einbinden
    ?>

<?php 
        if (isset($_GET["kochid"]) && !empty($_GET["kochid"])) {
            $koch = new Koch();

            if ($koch->loeschen($_GET["kochid"])) {  // Koch mit übergebenen ID löschen
                echo "<h2>Koch gelöscht</h2>";
            } else {
                echo "<h2>Fehler beim Löschen des Kochs</h2>";
            }
            echo '<meta http-equiv="refresh" content="3;url=koch.php">'; // Sicherere Weiterleitung
            exit();
        } else {
            header("Location: koch.php");  // falls keine kochid vorhanden ist
            exit();
        }  
    ?>
</body>
</html>