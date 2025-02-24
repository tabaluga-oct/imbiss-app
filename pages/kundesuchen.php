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
    <title>Kunde suchen</title>
    <?php 
        require_once("kunde.class.php");
    ?>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php 
        require_once("navigation.inc.php");  // Navigationsleiste einbinden
    ?>

    <?php 
        $kunde = new Kunde();

        if (!empty(array_filter($_POST))) {
            $kunde->suchen();
        } else {
    ?>   
    <div class="auagabe">
        <form action="" method="post">
            <label for="kundeid">Kunde ID: </label>
            <input type="text" id="kundeid" name="kundeid" value=""><br>
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
            <button type="submit">Suchen</button>
        </form>
    </div>   
    <?php  
    }
    ?>
</body>
</html>