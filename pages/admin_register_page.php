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
    <title>Admin Registrierung</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php 
        require_once("navigation.inc.php");
    ?>

    <h3>Neuen Admin registrieren</h3>
    <div class="register-container">
        <form action="admin_register.php" method="post">
            <label for="username">Benutzername:</label>
            <input type="text" name="username" required>

            <label for="password">Passwort:</label>
            <input type="password" name="password" required>

            <label for="password_repeat">Passwort wiederholen: </label>
            <input type="password" id="password_repeat" name="password_repeat" required><br><br>
            <button type="submit">registrieren</button>
        </form>
    </div>
</body>
</html>
