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
    <title>Bestellung Bearbeiten</title>
    <?php 
        require_once("bestellung.class.php");
    ?>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php
        // Inkludiert die Navigationsdatei
        require_once("navigation.inc.php");
    ?>

    <?php 
    // eine neue Instanz der 'Bestellung' Klasse erstellen
    $bestellung = new Bestellung();

    // Überprüft, ob der 'mode' Parameter im POST-Request gesetzt ist
    if (isset($_POST["mode"])) {
        // Überprüft den Wert des 'mode' Parameters, um die Aktion zu bestimmen.
        if ($_POST["mode"] == "null") {
            $bestellung->anlegen();
        } else {
            $bestellung->bearbeiten();
        }
        // Der 'refresh' Header verzögert die Weiterleitung um 3 Sekunden.
        header("refresh:3; url=bestellung.php");
    } else {  
    ?>
    <div class="ausgabe">
    <?php 
        $bdata = array();

        if (isset($_GET["bestellungid"])) {  // überprüfen, ob die URL die ID enthält 
            $bdata = $bestellung->lesenDatensatz($_GET["bestellungid"]); // Daten abrufen
            $bestellungid = $_GET["bestellungid"];  // die ID speichern
        
    ?>
            <!-- Tabelle erstellen -->
            <form action="" method="POST">
                <input type="hidden" id="mode" name="mode" value="<?php echo $bestellungid ?>">
                <label for="bestellungid">Nummer: </label>
                <input type="text" id="bestellungid" name="bestellungid" value="<?php echo $bestellungid ?>" disabled><br>

                <label for="kundeid">Kunde: </label>
                <?php echo $bestellung->einfSelect("kunde", "kundeid", $bdata["kundeid"], "name", "vorname"); ?><br>

                <label for="gekochtesgerichtid">Gekochtes Gericht: </label>
                <?php echo $bestellung->einfSelect("gekochtesgericht", "gekochtesgerichtid", $bdata["gekochtesgerichtid"], "gekochtesgerichtid"); ?><br>

                <label for="rezept_name">Rezept: </label>
                <input type="text" id="rezept_name" name="rezept_name" value="<?php echo $bdata["rezept_name"] ?>"><br>

                <label for="koch_name">Koch: </label>
                <input type="text" id="koch_name" name="koch_name" value="<?php echo $bdata["koch_vorname"] . " " . $bdata["koch_name"] ?>"><br>

                <label for="zeipunkt">Zeitpunkt: </label>
                <input type="datetime-local" id="zeitpunkt" name="zeitpunkt" value="<?php echo $bdata["zeitpunkt"] ?>"><br>

                <label for="preis">Preis: </label>
                <input type="text" id="preis" name="preis" value="<?php echo $bdata["preis"] ?>"><br>

                <label for="zahlungsart">Zahlungsart: </label>
                <input type="text" id="zahlungsart" name="zahlungsart" value="<?php echo $bdata["zahlungsart"] ?>"><br><br>

                <button type="submit">Änderung speichern</button>
            </form>

            <div class="button-container-loeschen">
                <a class="button" href="bestellungloeschen.php?bestellungid=<?php echo $bestellungid ?>">Bestellung Löschen</a>
            </div>
            <?php
            } else {
            ?>
                <form action="" method="POST">
                <input type="hidden" id="mode" name="mode" value="null">
                <label for="bestellungid">Nummer: </label>
                <input type="text" id="bestellungid" name="bestellungid" value="AUTO" disabled><br>

                <label for="kundeid">Kunde: </label>
                <?php echo $bestellung->einfSelect("kunde", "kundeid", Null, "vorname", "name"); ?><br>

                <label for="gekochtesgerichtid">Gekochtes Gericht: </label>
                <?php echo $bestellung->einfSelect("gekochtesgericht", "gekochtesgerichtid", Null, "gekochtesgerichtid"); ?><br>

                <label for="rezept_name">Rezept: </label>
                <input type="text" id="rezept_name" name="rezept_name" value=""><br>

                <label for="koch_name">Koch: </label>
                <input type="text" id="koch_name" name="koch_name" value=""><br>

                <label for="zeipunkt">Zeitpunkt: </label>
                <input type="datetime-local" id="zeitpunkt" name="zeitpunkt" value="<?= date('Y-m-d H:i:s'); ?>" required><br>

                <label for="preis">Preis: </label>
                <input type="text" id="preis" name="preis" value=""><br>

                <label for="zahlungsart">Zahlungsart: </label>
                <input type="text" id="zahlungsart" name="zahlungsart" value=""><br><br>

                <button type="submit">Neue Bestellung hinzufügen</button>
            </form>
            <?php
            }
            ?>
        </div>
    <?php
    }
    ?>
    </div>

    <!-- 'rezept' and 'koch' basierend auf 'gekochtes gericht' aktualisieren -->
     <script>
        console.log("Script gestartet");
        function updateRezeptKoch() {
            // Die ausgewählte 'gekochtesgerichtid' aus dem <select>-Feld abrufen
            var gekochtesgerichtid = document.getElementById("gekochtesgerichtid").value;

            // // Überprüfen, ob eine gültige ID vorhanden ist
            if (gekochtesgerichtid) {
                var xhr = new XMLHttpRequest();  // Erstellt ein neues XMLHttpRequest-Objekt (AJAX)
                xhr.open("GET", "bestellung_ajax.php?gekochtesgerichtid=" + gekochtesgerichtid, true);  // // GET-Request an PHP-Datei senden

                // Event-Listener für die Verarbeitung der Antwort
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);  // JSON-Antwort parsen
                            // Falls eine gültige Antwort vorhanden ist, die Felder aktualisieren
                            if (response) {
                                var rezeptFeld = document.getElementById("rezept_name");
                                var kochField = document.getElementById("koch_name");

                                // Überprüfen, ob die Elemente existieren, bevor sie befüllt werden
                                if (rezeptFeld && kochField) {
                                    rezeptFeld.value = response.rezept_name;
                                    kochField.value = response.koch_fullname;
                                } else {
                                    console.error("Eingabefelder für Rezept oder Koch nicht gefunden.");
                                }
                            }
                        } catch (e) {
                            console.error("Fehler beim Parsen der JSON-Antwort:", e);
                        }
                    } else {
                        console.error("Fehlerhafte Serverantwort, Statuscode:", xhr.status);
                    }
                };
                xhr.send();  // Anfrage senden
            }
        }
        // Event-Listener: Ruft updateRezeptKoch() auf, wenn der Wert des Dropdowns geändert wird
        document.getElementById("gekochtesgerichtid").addEventListener("change", updateRezeptKoch);
     </script>
</body>
</html>