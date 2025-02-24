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
    <title>Koch bearbeiten</title>
    <?php 
        require_once("koch.class.php");
    ?>
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>
    <?php
    // Inkludiert die Navigationsdatei
    require_once("navigation.inc.php");
    ?>

    <?php
    // Erstellt eine neue Instanz der 'koch' Klasse.
    $koch = new Koch();

    // Überprüft, ob der 'mode' Parameter im POST-Request gesetzt ist
    if (isset($_POST["mode"])) {
        // Überprüft den Wert des 'mode' Parameters, um die Aktion zu bestimmen.
        if ($_POST["mode"] == "null") {
            $koch->anlegen();
        } else {
            $koch->bearbeiten();
        }
        // Der 'refresh' Header verzögert die Weiterleitung um 3 Sekunden.
        header("refresh:3; url=koch.php");
    } else {
    ?>
    <div class="ausgabe"> 
    <?php
    
        $kdata = array();

        if (isset($_GET["kochid"])) { // check if kochid in in the url
            $kdata = $koch->lesenDatensatz($_GET["kochid"]);  // fetch the data
            $kochid = $_GET["kochid"];  // store the kochid
    ?>
            <!-- Tabelle erstellen -->
            <!-- to do -->
             <form action="" method="post">
                <input type="hidden" id="mode" name="mode" value="<?php echo $kochid; ?>">  
                <label for="kochid">Koch ID: </label>
                <input type="text" id="kochid" name="kochid" value="<?php echo $kochid; ?>" disabled><br>

                <label for="name">Name: </label>
                <input type="text" id="name" name="name" value="<?php echo $kdata["name"]; ?>"><br>

                <label for="vorname">Vorname: </label>
                <input type="text" id="vorname" name="vorname" value="<?php echo $kdata["vorname"]; ?>"><br>

                <label for="anzahl_von_sternen">Sternen: </label>
                <input type="number" id="anzahl_von_sternen" name="anzahl_von_sternen" value="<?php echo $kdata['anzahl_von_sternen']; ?>" min="0" max="5" oninput="updateStars(this.value)">
                <span id="sterne_anzeige"><?php echo str_repeat("⭐", $kdata["anzahl_von_sternen"]); ?></span><br>

                <label for="koch_alter">Alter: </label>
                <input type="number" id="koch_alter" name="koch_alter" value="<?php echo $kdata["koch_alter"]; ?>"><br>

                <label for="geschlecht">Geschlecht: </label>
                <select id="geschlecht" name="geschlecht">
                    <option value="m" <?php echo ($kdata["geschlecht"] == 'm') ? 'selected' : ''; ?>>Männlich (m)</option>
                    <option value="w" <?php echo ($kdata["geschlecht"] == 'w') ? 'selected' : ''; ?>>Weiblich (w)</option>
                    <option value="d" <?php echo ($kdata["geschlecht"] == 'd') ? 'selected' : ''; ?>>Divers (d)</option>
                </select><br>

                <label for="spezialgebiet">Spezialgebiet: </label>
                <input type="text" id="spezialgebiet" name="spezialgebiet" value="<?php echo $kdata["spezialgebiet"]; ?>"><br><br>

                <button type="submit">Änderung speichern</button>
             </form>

             <div class="button-container-loeschen">
                <a class="button" href="kochloeschen.php?kochid=<?php echo $kochid; ?>">Koch löschen</a>
            </div>
    <?php
        } else { 
    ?>
            <form action="" method="post">
                <input type="hidden" id="mode" name="mode" value="null">
                <label for="kochid">Koch ID: </label>
                <input type="text" id="kochid" name="kochid" value="AUTO" disabled><br>

                <label for="name">Name: </label>
                <input type="text" id="name" name="name" value=""><br>

                <label for="vorname">Vorname: </label>
                <input type="text" id="vorname" name="vorname" value=""><br>

                <label for="anzahl_von_sternen_neu">Sternen: </label>
                <input type="number" id="anzahl_von_sternen_neu" name="anzahl_von_sternen_neu" value="0" min="0" max="5" oninput="updateNewStars(this.value)"><br>
                <span id="sterne_anzeige_neu"></span><br>

                <label for="koch_alter">Alter: </label>
                <input type="number" id="koch_alter" name="koch_alter" value=""><br>

                <label for="geschlect">Geschlecht: </label>
                <select id="geschlecht" name="geschlecht" required>
                    <option value="m">Männlich (m)</option>
                    <option value="w">Weiblich (w)</option>
                    <option value="d">Divers (d)</option>
                </select><br>

                <label for="spezialgebiet">Spezialgebiet: </label>
                <input type="text" id="spezialgebiet" name="spezialgebiet" value=""><br><br>

                <button type="submit">Neuen Koch hinzufügen</button>
            </form>
    <?php
        }
    }
    ?>
    </div>
    <script>
        function updateStars(value) {
            // Update the star display for the first input
            document.getElementById("sterne_anzeige").innerHTML = "⭐".repeat(value);
        }
    </script>

<script>
    function updateNewStars(value) {
        // Get the number of stars from the input field
        var numStars = Math.max(0, Math.min(value, 5)); // Ensure the number is between 0 and 5
        
        // Update the star display for the second input
        document.getElementById("sterne_anzeige_neu").textContent = "⭐".repeat(numStars);
    }
    // Initialize the star display for the second input based on the initial input value
    document.addEventListener("DOMContentLoaded", function() {
        updateNewStars(document.getElementById("anzahl_von_sternen_neu").value);
    });
</script>
</body>
</html>