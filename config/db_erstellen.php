<?php 

// Datenbankverbindung (ohne die spezifische Datenbank, nur Serververbindung)
$host = "localhost";
$user = "root";  // MySQL username
$passwort = "";  // MySQL passwort
$db = "imbissverwaltung";  // Name der Datenbank

// Verbindung zum MySQL-Server herstellen
$conn = new mysqli($host, $user, $passwort);

// Verbidung überprüfen
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// überprüfen ob die Datenbank existiert
$result = $conn->query("SHOW DATABASES LIKE '$db'");
if ($result->num_rows == 0) {
    $conn->query("CREATE DATABASE  IF NOT EXISTS $db");
    echo "Datenbank '$db' wurde erstellt.<br>";
} else {
    echo "Datenbank existiert bereits, Erstellung wird übersprungen.<br>";
}

// wechseln zur erstellten oder vorhandenen Datenbank
$conn->select_db($db);

// Check if tables already exist
$tableCheck = $conn->query("SHOW TABLES LIKE 'koch'"); 
if ($tableCheck->num_rows == 0) {
    // Read the SQL file
    $sqlFile = '../sql/imbissverwaltung.sql'; // Path to .sql file
    if (file_exists($sqlFile)) {
        $sql = file_get_contents($sqlFile);

        // Execute SQL script
        if ($conn->multi_query($sql)) {
            do {
                // Check if there was an error while executing each query
                if ($result = $conn->store_result()) {
                    $result->free();
                }
            } while ($conn->next_result());
            echo "Tables created successfully!<br>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "SQL file not found!<br>";
    }
} else {
    echo "Tabellen existieren bereits, Erstellung wird übersprungen.<br>";
}

// Verbindung schließen
$conn->close();
?>