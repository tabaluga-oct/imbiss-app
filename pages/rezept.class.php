<?php
/**
 * Stellt ein Rezept im System dar.
 */
class Rezept {
    // Private Variable für die Tabelle 'rezept' in der Datenbank
    private $tabelle = "rezept";

    /* Löscht ein Rezept aus der Datenbank anhand seiner ID */
    public function loeschen($id) {
        // Datenbank verbinden
        require("../config/db.inc.php");
    
        // SQL-Statement vorbereiten
        $sql = "DELETE FROM " . $this->tabelle . " WHERE rezeptid = ?";
        
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

    /* Neues Rezept in der Dantenbank anlegen */
    public function anlegen() {
        // Datenbank verbinden
        require("../config/db.inc.php");

        $rezeptid = NULL;  // AUTO_INCREMENTED
        // SQL-Befehl vorbereiten
        $sql = "INSERT INTO " . $this->tabelle . "
            (rezeptid, name, dauer, speiseart, rezeptbeschreibung) 
            VALUES (?, ?, ?, ?, ?)";
        // Prepared statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param(
                'isiss',
                $rezeptid,
                $_POST["name"],
                $_POST["dauer"],
                $_POST["speiseart"],
                $_POST["rezeptbeschreibung"]
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

    /* Rezeptdaten verarbeiten */ 
    public function bearbeiten() {
        // Datenbank verbinden
        require("../config/db.inc.php");

        // SQL-Befehl vorbereiten
        $sql = "UPDATE " . $this->tabelle . " SET
                                            name = ?, 
                                            dauer = ?, 
                                            speiseart = ?, 
                                            rezeptbeschreibung = ?
                                      WHERE rezeptid = ?";

        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('sissi',
                            $_POST["name"],
                            $_POST["dauer"],
                            $_POST["speiseart"],
                            $_POST["rezeptbeschreibung"],
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
        $sql = "SELECT `name`, dauer, speiseart, rezeptbeschreibung
                       FROM " . $this->tabelle . 
                       " WHERE rezeptid = ?";
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
        $sql = "SELECT rezeptid, 
                        `name`, 
                        dauer, 
                        speiseart, 
                        rezeptbeschreibung
                        FROM " . $this->tabelle . 
                        " ORDER BY rezeptid";
        $this->baueRezeptTabelle($sql);  // die Tabellenbau-Funktion aufrufen
    }

    /* Tabellenbau Funktion */
    private function baueRezeptTabelle($sql) {
        // Verbindung zur Datenbank herstellen
        require("../config/db.inc.php");
        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->execute();
            // die Ergibnisse an PHP-Variablen binden
            $stmt->bind_result($rezeptid,
                                $name,
                                $dauer,
                                $speiseart,
                                $rezeptbeschreibung);
            // Tabelle bauen
            echo "<div class=\"table-wrapper\">";
            echo "<table id=\"zebra\">\n";
            echo "<thead>
                    <tr>
                        <th>Nummer</th><th>Name</th><th>Dauer in Minuten</th><th>Speiseart</th><th>rezeptbeschreibung</th><th>Bearbeiten</th>
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
                . htmlspecialchars($rezeptid)
                ."</td>\n\t<td>"
                . htmlspecialchars($name)
                ."</td>\n\t<td>"
                . htmlspecialchars($dauer)
                ."</td>\n\t<td>"
                . htmlspecialchars($speiseart)
                ."</td>\n\t<td>"
                . htmlspecialchars($rezeptbeschreibung)
                ."</td>\n\t<td>"
                ."<a href=\"rezeptbearbeiten.php?rezeptid=" .htmlspecialchars($rezeptid) ."\">bearbeiten</a>"
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