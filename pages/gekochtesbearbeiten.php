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
    <title>Gekochtes Gericht bearbeiten</title>
    <?php 
        require_once("gekochtes.class.php");
    ?>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php
    // Inkludiert die Navigationsdatei
    require_once("navigation.inc.php");
    ?>

    <?php 
    // Erstellt eine neue Instanz der 'gekochtes' Klasse.
    $gekochtes = new Gekochtes();

    // Überprüft, ob der 'mode' Parameter im POST-Request gesetzt ist
    if (isset($_POST["mode"])) {
        // Überprüft den Wert des 'mode' Parameters, um die Aktion zu bestimmen.
        if ($_POST["mode"] == "null") {
            $gekochtes->anlegen();
        } else {
            $gekochtes->bearbeiten();
        }
        // Der 'refresh' Header verzögert die Weiterleitung um 3 Sekunden.
        header("refresh:3; url=gekochtesgericht.php");
    } else {  
    ?>
    <div class="ausgabe">
    <?php 
        $gdata = array();

        if (isset($_GET["gekochtesgerichtid"])) {  // überprüfen, ob die URL die ID enthält 
            $gdata = $gekochtes->lesenDatensatz($_GET["gekochtesgerichtid"]); // Daten abrufen
            $gekochtesgerichtid = $_GET["gekochtesgerichtid"];  // die ID speichern
        
    ?>
            <!-- Tabelle erstellen -->
            <form action="" method="POST">
                <input type="hidden" id="mode" name="mode" value="<?php echo $gekochtesgerichtid ?>">
                <label for="gekochtesgerichtid">Nummer: </label>
                <input type="text" id="gekochtesgerichtid" name="gekochtesgerichtid" value="<?php echo $gekochtesgerichtid ?>" disabled><br>

                <label for="kochid">Koch: </label>
                <?php echo $gekochtes->einfSelect("koch", "kochid", "name", $gdata["kochid"], "vorname"); ?><br>

                <label for="rezeptid">Rezept: </label>
                <?php echo $gekochtes->einfSelect("rezept", "rezeptid", "name", $gdata["rezeptid"]); ?><br><br>

                <button type="submit">Änderung speichern</button>
            </form>

            <div class="button-container-loeschen">
                <a class="button" href="gekochtesloeschen.php?gekochtesgerichtid=<?php echo $gekochtesgerichtid ?>">Gekochtes Gericht Löschen</a>
            </div>
            <?php
            } else {
            ?>
                <form action="" method="POST">
                    <input type="hidden" id="mode" name="mode" value="null">
                    <label for="gekochtesgerichtid">Nummer: </label>
                    <input type="text" id="gekochtesgerichtid" name="gekochtesgerichtid" value="AUTO" disabled><br>

                    <label for="kochid">Koch: </label>
                    <?php echo $gekochtes->einfSelect("koch", "kochid", "name", Null, "vorname"); ?><br>

                    <label for="rezeptid">Rezept: </label>
                    <?php echo $gekochtes->einfSelect("rezept", "rezeptid", "name", Null); ?><br><br>

                    <button type="submit">Neues Gekochtes Gericht hinzufügen</button>
                </form>
            <?php
            }
            ?>
        </div>
    <?php
    }
    ?>
    </div>
</body>
</html>