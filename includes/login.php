<?php
session_start();
include("../config/db.inc.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Query to check if the user exists in the database
    $stmt = $mysqli->prepare("SELECT password FROM `admin` WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Fetch the hashed password from the database
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password entered by the user with the stored hashed password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: ../pages/navigation.inc.php"); // Redirect to navigation page
            exit();
        } else {
            echo "Falscher Benutzername oder Passwort."; // Incorrect password
        }
    } else {
        echo "Falscher Benutzername oder Passwort."; // User not found
    }

    $stmt->close();
}
?>
