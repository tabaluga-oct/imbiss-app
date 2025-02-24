<?php 
/**
 * Stellt ein Gekochte Gericht im System dar.
 */
class Gekochtes {
    // Private Variable für die Tabelle 'gekochtesgericht' in der Datenbank
    private $tabelle = "gekochtesgericht";


    /* ein Gekochtes Gericht anhand seiner ID aus der Datenbank löschen */
    public function loeschen($id) {
        // Datenbank verbinden
        require("../config/db.inc.php");

        // SQL-Statement vorbereiten
        $sql = "DELETE FROM " . $this->tabelle . " WHERE gekochtesgerichtid = ?";

        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('i', $id);

            // Statement ausführen und auf Erfolg prüfen
            if ($stmt->execute()) {
                // Statement und Verbindung schließen wenn er erfolgreich ist
                $stmt->close();
                $mysqli->close();
                return true;  // Erfolgreiches Löschen
            } else {
                // Fehler beim Löschen
                $stmt->close();
                $mysqli->close();
                return false;  // Fehler beim Löschen
            }
        } else {
            // Fehler ber der Vorbereitung des Statements
            $mysqli->close();
            return false;
        }
    }


    /* Neues Gekochtes Gericht in der Dantenbank anlegen */
    public function anlegen() {
        // Datenbank verbinden
        require("../config/db.inc.php");

        $gekochtesgerichtid = NULL;  // AUTO_INCREMENTED

        // SQL-Befehl vorbereiten
        $sql = "INSERT INTO " . $this->tabelle . " (gekochtesgerichtid, kochid, rezeptid) VALUES (?, ?, ?)";
        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('iii', 
                              $gekochtesgerichtid, 
                              $_POST["kochid"],
                              $_POST["rezeptid"]);
                
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


    /* Gerichtdaten verarbeiten */
    public function bearbeiten() {
        // Datenbank verbinden
        require("../config/db.inc.php");

        // SQL-Befehl vorbereiten
        $sql = "UPDATE " . $this->tabelle . " SET 
                                            kochid = ?,
                                            rezeptid = ?
                                      WHERE gekochtesgerichtid = ?";

        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('iii',
                            $_POST["kochid"],
                            $_POST["rezeptid"],
                            $_POST["mode"]);
            if ($stmt->execute()) {
                echo "<h2>Datensatz erfolgreich gespeichert!</h2>\n";
            } else {
                echo "<h2>Fehler beim Speichern!</h2>\n";
            }
            // Statement schließen
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
        // mit JOIN auch Daten von anderen Tabellen holen
        $sql = "SELECT k.kochid,
                       k.name,
                       k.vorname,
                       r.rezeptid,
                       r.name
                       FROM " . $this->tabelle . " g 
                       JOIN koch k ON k.kochid = g.kochid
                       JOIN rezept r ON r.rezeptid = g.rezeptid
                       WHERE g.gekochtesgerichtid = ?";
        
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
        $sql = "SELECT g.gekochtesgerichtid,
                       k.kochid,
                       k.name,
                       k.vorname,
                       r.rezeptid,
                       r.name
                       FROM " . $this->tabelle . " g 
                       JOIN koch k ON k.kochid = g.kochid
                       JOIN rezept r ON r.rezeptid = g.rezeptid
                       ORDER BY g.gekochtesgerichtid";
        
        $this->baueGerichtTabelle($sql);
    }


    /* Tabellenbau Funktion */
    private function baueGerichtTabelle($sql) {
        // Verbindung zur Datenbank herstellen
        require("../config/db.inc.php");

        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->execute();
            // die Ergibisse an PHP-Variablen binden
            $stmt->bind_result($gekochtesgerichtid,
                               $kochid,
                               $kochName,
                               $kochVorname,
                               $rezeptid,
                               $rezeptName);

            // Tabelle bauen
            echo "<div class=\"table-wrapper\">";
            echo "<table id=\"zebra\">\n";
            echo "<thead>
                    <tr>
                        <th>Nummer</th><th>Koch</th><th>Rezept</th><th>Bearbeiten</th>
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
                . htmlspecialchars($gekochtesgerichtid)
                ."</td>\n\t<td>"
                . htmlspecialchars($kochVorname . " " . $kochName)
                ."</td>\n\t<td>"
                . htmlspecialchars($rezeptName)
                ."</td>\n\t<td>"
                ."<a href=\"gekochtesbearbeiten.php?gekochtesgerichtid=" .htmlspecialchars($gekochtesgerichtid) ."\">bearbeiten</a>"
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


    /* ein Dropdown-Menü generieren */
    public function einfSelect($tab, $wert, $text1, $def, $text2 = null) {
        // Verbindung zur Datenbank herstellen
        require("../config/db.inc.php");

        // Überprüfe, ob die Verbindung erfolgreich hergestellt wurde.
        if (!isset($mysqli)) {
            die("Datenbankverbindung konnte nicht hergestellt werden."); // Fehlerbehandlung ist wichtig!
        }

        // HTML-Code für das <select>-Element erstellen
        $s = "<select name=\"" . $wert . "\" id=\"" . $wert . "\">";

        // SQL-Befehl erstellen
        $sql = "SELECT " . $wert . ", " . $text1;
        if ($text2) {
            $sql .= ", " . $text2;
        }
        $sql .= " FROM " . $tab;

        // Prepared Statement vorbereiten
        if ($stmt = $mysqli->prepare($sql)) {
            // SQL-Befehl ausführen
            $stmt->execute();

            // Ergebnisvariablen an die Spalten binden
            if ($text2) {
                $stmt->bind_result($wert, $text1, $text2);
            } else {
                $stmt->bind_result($wert, $text1);
            }
            
            // Durch die Ergebnisse der Abfrage iterieren
            while ($stmt->fetch()) {
                // Option für jeden Datendatz erstellen
                $fullName = $text2 ? $text1 . " " . $text2 : $text1;
                $s = $s . "<option value=\"" . $wert . "\"";

                // überprüfen, ob der aktuelle Wert dem Standardwert entspricht
                if ($wert == $def) {
                    $s = $s . " selected";  // Option als vorausgewählt markieren
                }

                // Text der Option hinzufügen
                $s = $s . ">" . htmlspecialchars($wert) . " | " . htmlspecialchars($fullName) . "</option>";
            }

            // Das </select>-Tag schließen
            $s = $s . "</select>";

            // Das generierte Dropdowm-menü zurückgeben
            return $s;
        } else {
            // Fehlerfall: Prepared Statement konnte nicht erstellt werden
            return false;
        }
    }
}
?>