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
    <title>Rezept bearbeiten</title>
    <?php 
        require_once("rezept.class.php");
    ?>
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>
    <?php
    // Inkludiert die Navigationsdatei
    require_once("navigation.inc.php");
    ?>

    <?php
    // Erstellt eine neue Instanz der 'rezept' Klasse.
    $rezept = new rezept();

    // Überprüft, ob der 'mode' Parameter im POST-Request gesetzt ist
    if (isset($_POST["mode"])) {
        // Überprüft den Wert des 'mode' Parameters, um die Aktion zu bestimmen.
        if ($_POST["mode"] == "null") {
            $rezept->anlegen();
        } else {
            $rezept->bearbeiten();
        }
        // Der 'refresh' Header verzögert die Weiterleitung um 3 Sekunden.
        header("refresh:3; url=rezept.php");
    } else {
    ?>
    <div class="ausgabe"> 
    <?php
    
        $rdata = array();

        if (isset($_GET["rezeptid"])) { // check if rezeptid in the url
            $rdata = $rezept->lesenDatensatz($_GET["rezeptid"]);  // fetch the data
            $rezeptid = $_GET["rezeptid"];  // store the rezeptid
    ?>
            <!-- Tabelle erstellen -->
            <!-- to do -->
             <form action="" method="post">
                <input type="hidden" id="mode" name="mode" value="<?php echo $rezeptid; ?>">  
                <label for="rezeptid">rezept ID: </label>
                <input type="text" id="rezeptid" name="rezeptid" value="<?php echo $rezeptid; ?>" disabled><br>
                <label for="name">Name: </label>
                <input type="text" id="name" name="name" value="<?php echo $rdata["name"]; ?>"><br>
                <label for="dauer">Dauer in Minuten: </label>
                <input type="number" id="dauer" name="dauer" value="<?php echo $rdata["dauer"]; ?>"><br>
                <label for="speiseart">Speiseart: </label>
                <input type="text" id="speiseart" name="speiseart" value="<?php echo $rdata["speiseart"]; ?>"><br>
                <label for="rezeptbeschreibung">Rezeptbeschreibung: </label>
                <textarea id="rezeptbeschreibung" name="rezeptbeschreibung"><?php echo $rdata["rezeptbeschreibung"]; ?></textarea><br><br>
                <button type="submit">Änderung speichern</button>
             </form>

             <div class="button-container-loeschen">
                <a class="button" href="rezeptloeschen.php?rezeptid=<?php echo $rezeptid; ?>">Rezept löschen</a>
            </div>
    <?php
        } else { 
    ?>
            <form action="" method="post">
                <input type="hidden" id="mode" name="mode" value="null">
                <label for="rezeptid">rezept ID: </label>
                <input type="text" id="rezeptid" name="rezeptid" value="AUTO" disabled><br>
                <label for="name">Name: </label>
                <input type="text" id="name" name="name" value=""><br>
                <label for="dauer">Dauer in Minuten: </label>
                <input type="number" id="dauer" name="dauer" value=""><br>
                <label for="speiseart">Speiseart: </label>
                <input type="text" id="speiseart" name="speiseart" value=""><br>
                <label for="rezeptbeschreibung">Rezeptbeschreibung: </label>
                <textarea id="rezeptbeschreibung" name="rezeptbeschreibung" row="4" cols="50" value=""></textarea><br><br>
                <button type="submit">Neues Rezept hinzufügen</button>
            </form>
    <?php
        }
    }
    ?>
    </div>

</body>
</html>