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
    <title>Kunde bearbeiten</title>
    <?php 
        require_once("kunde.class.php");
    ?>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
<?php
    // Inkludiert die Navigationsdatei
    require_once("navigation.inc.php");
    ?>

    <?php 
    // Erstellt eine neue Instanz der 'kunde' Klasse.
    $kunde = new Kunde();

    // Überprüft, ob der 'mode' Parameter im POST-Request gesetzt ist
    if (isset($_POST["mode"])) {
        // Überprüft den Wert des 'mode' Parameters, um die Aktion zu bestimmen.
        if ($_POST["mode"] == "null") {
            $kunde->anlegen();
        } else {
            $kunde->bearbeiten();
        }
        // Der 'refresh' Header verzögert die Weiterleitung um 3 Sekunden.
        header("refresh:3; url=kunde.php");
    } else { 
    ?>
    <div class="ausgabe">
    <?php 

        $kundeData = array();

        if (isset($_GET["kundeid"])) { // check if kundeid is in the url
            $kundeData = $kunde->lesenDatensatz($_GET["kundeid"]);  // fetch the data
            $kundeid = $_GET["kundeid"];  // store the kundeid
    ?>
        <!-- Tabelle in Browser erstellen -->
        <form action="" method="post">
            <input type="hidden" id="mode" name="mode" value="<?php echo $kundeid; ?>">
            <label for="kundeid">Kunde ID: </label>
            <input type="text" id="kundeid" name="kundeid" value="<?php echo $kundeid; ?>" disabled><br>
            <label for="name">Name: </label>
            <input type="text" id="name" name="name" value="<?php echo $kundeData["name"]; ?>"><br>
            <label for="vorname">Vorname: </label>
            <input type="text" id="vorname" name="vorname" value="<?php echo $kundeData["vorname"]; ?>"><br>
            <label for="email">E-mail: </label>
            <input type="text" id="email" name="email" value="<?php echo $kundeData["email"]; ?>"><br>
            <label for="lieblingsgericht">Lieblingsgericht: </label>
            <input type="text" id="lieblingsgericht" name="lieblingsgericht" value="<?php echo $kundeData["lieblingsgericht"]; ?>"><br>
            <label for="plz">Plz: </label>
            <input type="text" id="plz" name="plz" value="<?php echo $kundeData["plz"]; ?>"><br>
            <label for="ort">Ort: </label>
            <input type="text" id="ort" name="ort" value="<?php echo $kundeData["ort"]; ?>"><br>
            <label for="strasse">Straße: </label>
            <input type="text" id="strasse" name="strasse" value="<?php echo $kundeData["strasse"]; ?>"><br>
            <label for="strassenr">Straßenummer: </label>
            <input type="text" id="strassenr" name="strassenr" value="<?php echo $kundeData["strassenr"]; ?>"><br>
            <label for="telefonnr">Telefonnummer: </label>
            <input type="text" id="telefonnr" name="telefonnr" value="<?php echo $kundeData["telefonnr"]; ?>"><br><br>
            <button type="submit">Änderung speichern</button>
        </form>

        <div class="button-container-loeschen">
            <a class="button" href="kundeloeschen.php?kundeid=<?php echo $kundeid; ?>">Kunde löschen</a>
        </div>
        <?php
        } else {
        ?>

            <form action="" method="post">
                <input type="hidden" id="mode" name="mode" value="null">
                <label for="kundeid">Kunde ID: </label>
                <input type="text" id="kundeid" name="kundeid" value="AUTO" disabled><br>
                <label for="name">Name: </label>
                <input type="text" id="name" name="name" value=""><br>
                <label for="vorname">Vorname: </label>
                <input type="text" id="vorname" name="vorname" value=""><br>
                <label for="email">E-mail: </label>
                <input type="text" id="email" name="email" value=""><br>
                <label for="lieblingsgericht">Lieblingsgericht: </label>
                <input type="text" id="lieblingsgericht" name="lieblingsgericht" value=""><br>
                <label for="plz">Plz: </label>
                <input type="text" id="plz" name="plz" value=""><br>
                <label for="ort">Ort: </label>
                <input type="text" id="ort" name="ort" value=""><br>
                <label for="strasse">Straße: </label>
                <input type="text" id="strasse" name="strasse" value=""><br>
                <label for="strassenr">Straßenummer: </label>
                <input type="text" id="strassenr" name="strassenr" value=""><br>
                <label for="telefonnr">Telefonnummer: </label>
                <input type="text" id="telefonnr" name="telefonnr" value=""><br><br>
                <button type="submit">Neue Kunde hinzufügen</button>
            </form>
        <?php 
        }
    }
        ?>
    </div>
</body>
</html>