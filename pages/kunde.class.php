<?php 
/**
 * Stellt eine Kunde im System dar.
 */
class Kunde {
    // Private Variable für die Tabelle 'kunde' in der Datenbank
    private $tabelle = "kunde";

    /* eine Kunde aus der Datenbank anhand ihre ID löschen */
    public function loeschen($id) {
        // Datenbank verbinden
        require("../config/db.inc.php");
    
        // SQL-Statement vorbereiten
        $sql = "DELETE FROM " . $this->tabelle . " WHERE kundeid = ?";
        
        // Prepared Statement verwenden, um SQl-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $id);
    
            // Statement ausführen und auf Erfolg prüfen
            if ($stmt->execute()) {
                // Statement und Verbindung schließen, wenn es erfolgreich war
                $stmt->close();
                $mysqli->close();
                return true; // Erfolgreiches Löschen
            } else {
                // Fehler beim Löschen
                $stmt->close();
                $mysqli->close();
                return false; // Fehler beim Löschen
            }
        } else {
            // Fehler bei der Vorbereitung des Statements
            $mysqli->close();
            return false;
        }
    }
    

    /* Kunde in der Datenbank suchen */
    public function suchen() {
        // SQL-Statement vorbereiten
        $sql = "SELECT kundeid,
                       `name`, 
                       vorname, 
                       email,
                       lieblingsgericht,
                       plz,
                       ort,
                       strasse,
                       strassenr,
                       telefonnr
                       FROM " . $this->tabelle . 
                       " WHERE 1=1";  // Start mit einer wahren Bedienung
        $params =[];
        $types = "";  // Datentypen für bind_param()

        foreach ($_POST as $feld => $wert) {
            if (!empty($wert)) {
                if (!empty($wert)) {
                    if ($feld === "kundeid") {
                        $sql .= " AND " . $feld . " = ?";  // Exact match for integers
                        $params[] = (int)$wert;  // Ensure it's an integer
                        $types .= "i";  // Integer type
                    } else {
                        $sql .= " AND " . $feld . " LIKE ?";
                        $params[] = "%$wert%";
                        $types .= "s";  // alle Werte als String annehmen
                    }
                }
            }
        }
        $this->baueKundeTabelle($sql, $params, $types);
    }

    /* Neue Kunde in der Datenbank anlegen */
    public function anlegen() {
        // Datenbank verbinden
        require("../config/db.inc.php");

        $kundeid = NULL;  // AUTO_INCREMENTED
        // SQL-Statement vorbereiten
        $sql = "INSERT INTO " . $this->tabelle . " (
                                        kundeid, 
                                        name,
                                        vorname,
                                        email,
                                        lieblingsgericht,
                                        plz,
                                        ort,
                                        strasse,
                                        strassenr,
                                        telefonnr)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // Prepared statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param(
                'isssssssss',
                $kundeid,
                $_POST["name"],
                $_POST["vorname"],
                $_POST["email"],
                $_POST["lieblingsgericht"],
                $_POST["plz"],
                $_POST["ort"],
                $_POST["strasse"],
                $_POST["strassenr"],
                $_POST["telefonnr"]
            );
            if ($stmt->execute()) {
                echo "<h2>Datensatz erfolgreich gespeichert!</h2>\n";
            } else {
                echo "<h2>Fehler beim Speichern!</h2>\n";
            }
            // statement schließen
            $stmt->close();
        }
        // Datenbank-Verbindung schließen
        $mysqli->close(); 
    }

    /* Kundendaten bearbeiten */
    public function bearbeiten() {
        // Datenbank verbinden
        require("../config/db.inc.php");

        // SQl-Befehl vorbereiten
        $sql = "UPDATE " . $this->tabelle . " SET
                                            name = ?,
                                            vorname = ?,
                                            email = ?,
                                            lieblingsgericht = ?,
                                            plz = ?,
                                            ort = ?,
                                            strasse = ?,
                                            strassenr = ?,
                                            telefonnr = ?
                                      WHERE kundeid = ?";
        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('sssssssssi',
                            $_POST["name"],
                            $_POST["vorname"],
                            $_POST["email"],
                            $_POST["lieblingsgericht"],
                            $_POST["plz"],
                            $_POST["ort"],
                            $_POST["strasse"],
                            $_POST["strassenr"],
                            $_POST["telefonnr"],
                            $_POST["mode"]);
            if ($stmt->execute()) {
                echo "<h2>Datensatz erfolgreich gespeichert!</h2>\n";
            } else {
                echo "<h2>Fehler beim Speichern!</h2>\n";
            }
            // Statemeent schließen
            $stmt->close();
        }
        // Verbindung schließen
        $mysqli->close();
    } 

    /* Alle Daten aus der Tabelle in ein Array speichern */
    public function lesenDatensatz($id) {
        // leer Array definieren
        $data = array();
        // Verbindung zur Datenbank herstellen
        require("../config/db.inc.php");

        // SQL-Statement vorbereiten
        $sql = "SELECT `name`, 
                       vorname, 
                       email,
                       lieblingsgericht,
                       plz,
                       ort,
                       strasse,
                       strassenr,
                       telefonnr
                       FROM " . $this->tabelle . 
                       " WHERE kundeid = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $ergibnis = $stmt->get_result();  // ergibnis holen
            $data = $ergibnis->fetch_assoc();  // das ergibnis als assoziatives Array speichern
            $stmt->close();
            $mysqli->close();
        }
        return($data);
    }

    /* Alle Daten aus der Tabelle ausgeben */
    public function lesenAlleDaten() {
        // SQL-Statement vorbereiten
        $sql = "SELECT kundeid, 
                      `name`, 
                      vorname, 
                      email,
                      lieblingsgericht,
                      plz,
                      ort,
                      strasse,
                      strassenr,
                      telefonnr
                      FROM " . $this->tabelle . 
                      " ORDER BY kundeid";
        $this->baueKundeTabelle($sql);  // die Tabellenbau-Funktion aufrufen 
    }

    /* Tabellen in den Browser bauen */
    private function baueKundeTabelle($sql, $params = [], $types = "") {
        // Verbindung zur Datenbank herstellen
        require("../config/db.inc.php");
        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            // die Ergibnisse an PHP-Variablen binden
            $stmt->bind_result($kundeid,
                                $name,
                                $vorname,
                                $email,
                                $lieblingsgericht,
                                $plz,
                                $ort,
                                $strasse,
                                $strassenr,
                                $telefonnr);
            // Tabelle bauen
            echo "<div class=\"table-wrapper\">";
            echo "<table id=\"zebra\">\n";
            echo "<thead>
                    <tr>
                        <th>Nummer</th><th>Name</th><th>Vorname</th><th>Email</th><th>Lieblingsgericht</th><th>Plz</th><th>Ort</th><th>Strasse</th><th>Strassenr</th><th>telefonnr</th><th>Bearbeiten</th>
                    </tr>
                  </thead>
                  <tbody>\n";
            $count = 0;
            while ($stmt -> fetch()) {
                $count ++;
                $zebratyp = "ungerade";
                echo "<tr ";
                if($count % 2 == 0) {
                    $zebratyp = "gerade";
                }
                echo "class=\"" .$zebratyp
                ."\">\n\t<td>"
                . htmlspecialchars($kundeid)
                ."</td>\n\t<td>"
                . htmlspecialchars($name)
                ."</td>\n\t<td>"
                . htmlspecialchars($vorname)
                ."</td>\n\t<td>"
                . htmlspecialchars($email)
                ."</td>\n\t<td>"
                . htmlspecialchars($lieblingsgericht)
                ."</td>\n\t<td>"
                . htmlspecialchars($plz)
                ."</td>\n\t<td>"
                . htmlspecialchars($ort)
                ."</td>\n\t<td>"
                . htmlspecialchars($strasse)
                ."</td>\n\t<td>"
                . htmlspecialchars($strassenr)
                ."</td>\n\t<td>"
                . htmlspecialchars($telefonnr)
                ."</td>\n\t<td>"
                ."<a href=\"kundebearbeiten.php?kundeid=" .htmlspecialchars($kundeid) ."\">bearbeiten</a>"
                ."</td>\n</tr>";
            }
            echo "</table>";
            echo "</div>";
            // Statement schließen
            $stmt->close();
        }   
        // Verbindung schließen
        $mysqli->close(); 
    }
}
?>