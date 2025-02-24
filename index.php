<?php 
    // Session starten, um den Login-Status zu speichern
    session_start();

    // prüfen ob der Admin bereits eingeloggt ist
    if (isset($_SESSION['admin_logged_in'])) {
        // wenn ja, Weiterleitung zur Navigationsseite
        header("Location: pages/navigation.inc.php");  
        exit();
    }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imbissverwaltung</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<body>
    <h2>Admin Login</h2>
    
    <div class="login-container">
        <form action="includes/login.php" method="post">
            <label for="username">Benutzername:</label>
            <input type="text" name="username" placeholder="pepsi" required>
            <label for="password">Passwort:</label>
            <input type="password" name="password" placeholder="123" required><br><br>
            <button type="submit">Login</button>
        </form>
        <br><br>
    </div>
</body>
</html>