<?php
// session starten, um den Benutzeranmeldestatus zu überprüfen
// Session nur starten, wenn noch keine aktiv ist
if (session_status() === PHP_SESSION_NONE) {
    require_once("../config/session_start.php");
}
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
 	<title>Kursverwaltung</title>
	<link rel="stylesheet" href="../assets/styles.css" />
</head>
<body>
<h2>Willkommen, <?php echo $_SESSION['admin_username']; ?>! 
    <a class="button logout-btn" href="../includes/logout.php">Logout</a>
</h2>

<h3>Imbissverwaltung</h3>
 
<div class="nav">
    <a class="button" href="koch.php">Koch</a>
    <a class="button" href="kunde.php">Kunde</a>
    <a class="button" href="rezept.php">Rezept</a>
    <a class="button" href="gekochtesgericht.php">Gekochtes Gericht</a>
    <a class="button" href="bestellung.php">Bestellung</a>
    <a class="button" href="admin_register_page.php">neue Admin registrieren</a>
</div>
</body>
</html>