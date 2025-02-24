<?php
/**
 * Stellt einen Koch im System dar.
 */
class Koch {
    // Private Variable für die Tabelle 'koch' in der Datenbank
    private $tabelle = "koch";

    /* Löscht einen Koch aus der Datenbank anhand seiner ID */
    public function loeschen($id) {
        // Datenbank verbinden
        require("../config/db.inc.php");
    
        // SQL-Statement vorbereiten
        $sql = "DELETE FROM " . $this->tabelle . " WHERE kochid = ?";
        
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

    /* Neuen Koch in der Dantenbank anlegen */
    public function anlegen() {
        // Datenbank verbinden
        require("../config/db.inc.php");

        /*
        real_escape_string() is unnecessary inside prepared statements.
        prepared statements automatically escape inputs, making SQL injection impossible.
        */

        $kochid = NULL;  // AUTO_INCREMENTED
        // SQL-Befehl vorbereiten
        $sql = "INSERT INTO " . $this->tabelle . "
            (kochid, name, vorname, anzahl_von_sternen, koch_alter, geschlecht, spezialgebiet) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        // Prepared statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param(
                'issiiss',
                $kochid,
                $_POST["name"],
                $_POST["vorname"],
                $_POST["anzahl_von_sternen_neu"],
                $_POST["koch_alter"],
                $_POST["geschlecht"],
                $_POST["spezialgebiet"]
            );
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

    /* Kochdaten verarbeiten */ 
    public function bearbeiten() {
        // Datenbank verbinden
        require("../config/db.inc.php");

        // SQL-Befehl vorbereiten
        $sql = "UPDATE " . $this->tabelle . " SET
                                            name = ?,
                                            vorname = ?,
                                            anzahl_von_sternen = ?,
                                            koch_alter = ?,
                                            geschlecht = ?,
                                            spezialgebiet = ?
                                      WHERE kochid = ?";

        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('ssiissi',
                            $_POST["name"],
                            $_POST["vorname"],
                            $_POST["anzahl_von_sternen"],
                            $_POST["koch_alter"],
                            $_POST["geschlecht"],
                            $_POST["spezialgebiet"],
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

    /* alle Daten aus der Tabelle in ein Array speichern */
    public function lesenDatensatz($id) {
        // leer Array definieren
        $data = array();
        // Verbindung zur Datenbank herstellen
        require("../config/db.inc.php");

        // SQL-Statement vorbereiten
        $sql = "SELECT `name`, 
                       vorname, 
                       anzahl_von_sternen, 
                       koch_alter, 
                       geschlecht, 
                       spezialgebiet
                       FROM " . $this->tabelle . 
                       " WHERE kochid = ?";
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

    /* alle Daten aus der Tabelle ausgeben */
    public function lesenAlleDaten() {
        // SQL-Statement vorbereiten
        $sql = "SELECT kochid, 
                       `name`, 
                       vorname, 
                       anzahl_von_sternen, 
                       koch_alter, 
                       geschlecht, 
                       spezialgebiet
                       FROM " . $this->tabelle . 
                       " ORDER BY kochid";
        $this->baueKochTabelle($sql);  // die Tabellenbau-Funktion aufrufen
    }

    /* Tabellenbau Funktion */
    private function baueKochTabelle($sql) {
        // Verbindung zur Datenbank herstellen
        require("../config/db.inc.php");

        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->execute();
            // die Ergibnisse an PHP-Variablen binden
            $stmt->bind_result($kochid,
                                $name,
                                $vorname,
                                $anzahl_von_sternen,
                                $koch_alter,
                                $geschlecht,
                                $spezialgebiet);
            // Tabelle bauen
            echo "<div class=\"table-wrapper\">";
            echo "<table id=\"zebra\">\n";
            echo "<thead>
                    <tr>
                        <th>Nummer</th><th>Name</th><th>Vorname</th><th>Sternen</th><th>Alter</th><th>Geschlecht</th><th>Spezialgebiet</th><th>Bearbeiten</th>
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
                . htmlspecialchars($kochid)
                ."</td>\n\t<td>"
                . htmlspecialchars($name)
                ."</td>\n\t<td>"
                . htmlspecialchars($vorname)
                ."</td>\n\t<td>";
                
                // Now add the PHP logic to handle the stars
            echo str_repeat("⭐", htmlspecialchars($anzahl_von_sternen));


            echo  "</td>\n\t<td>"
                . htmlspecialchars($koch_alter)
                ."</td>\n\t<td>"
                . htmlspecialchars($geschlecht)
                ."</td>\n\t<td>"
                . htmlspecialchars($spezialgebiet)
                ."</td>\n\t<td>"
                ."<a href=\"kochbearbeiten.php?kochid=" .htmlspecialchars($kochid) ."\">bearbeiten</a>"
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