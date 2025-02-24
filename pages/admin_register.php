<?php
// session starten, um den Benutzeranmeldesstatus zu überprüfen
require_once("../config/session_start.php");

require_once "../config/db.inc.php"; // Connect to DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password']; // Hash password
    $password_repeat = $_POST['password_repeat'];

    // Check if passwords match
    if ($password !== $password_repeat) {
        echo "Die Passwörter stimmen nicht überein!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if username already exists
        $stmt = $mysqli->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Benutzername existiert bereits!";
            header("refresh:2; url=admin_register_page.php");
            exit();
        } else {
            // Insert new admin
            $stmt = $mysqli->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);
            if ($stmt->execute()) {
                echo "Admin erfolgreich registriert!";
                header("refresh:2; url=admin_register_page.php");;
                exit();
            } else {
                echo "Fehler beim Registrieren.";
                header("refresh:2; url=admin_register_page.php");
                exit();
            }
        }
        $stmt->close();
        $mysqli->close();
    }
}
?>
