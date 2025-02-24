<?php 
/**
 * Stellt eine Bestellung im System dar.
 */
class Bestellung {
    // Private Variable für die Tabelle 'bestellung' in der Datenbank
    private $tabelle = "bestellung";


    /* eine bestellung  anhand seiner ID aus der Datenbank löschen */
    public function loeschen($id) {
        // Datenbank verbinden
        require("../config/db.inc.php");

        // SQL-Befehl vorbereiten
        $sql = "DELETE FROM " . $this->tabelle . " WHERE bestellungid = ?";

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


    /* Neue Bestellung in der Dantenbank anlegen */
    public function anlegen() {
        // Datenbank verbinden
        require("../config/db.inc.php");

        $bestellungid = NULL;  // AUTO_INCREMENTED

        // SQL-Befehl vorbereiten
        $sql = "INSERT INTO " . $this->tabelle . " (kundeid, gekochtesgerichtid, zeitpunkt, preis, zahlungsart) VALUES (?, ?, ?, ?, ?)";
        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('iisss',
                              $_POST["kundeid"],
                              $_POST["gekochtesgerichtid"],
                              $_POST["zeitpunkt"],
                              $_POST["preis"],
                              $_POST["zahlungsart"]);
                
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


    /* Bestellungsdaten verarbeiten */
    public function bearbeiten() {
        // Datenbank verbinden
        require("../config/db.inc.php");

        // SQL-Befehl vorbereiten
        $sql = "UPDATE " . $this->tabelle . " SET 
                                            kundeid = ?,
                                            gekochtesgerichtid = ?,
                                            zeitpunkt = ?,
                                            preis = ?,
                                            zahlungsart = ?
                                      WHERE bestellungid = ?";

        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('iisssi',
                            $_POST["kundeid"],
                            $_POST["gekochtesgerichtid"],
                            $_POST["zeitpunkt"],
                            $_POST["preis"],
                            $_POST["zahlungsart"],
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
        $sql = "SELECT b.bestellungid,
                       kunde.kundeid,
                       kunde.name AS kunde_name, 
                       kunde.vorname AS kunde_vorname,
                       g.gekochtesgerichtid,
                       r.rezeptid,
                       r.name AS rezept_name,
                       koch.kochid,
                       koch.name AS koch_name,
                       koch.vorname AS koch_vorname,
                       b.zeitpunkt,
                       b.preis,
                       b.zahlungsart
                       FROM " . $this->tabelle . " b 
                       JOIN kunde ON kunde.kundeid = b.kundeid
                       JOIN gekochtesgericht g ON g.gekochtesgerichtid = b.gekochtesgerichtid
                       JOIN rezept r ON r.rezeptid = g.rezeptid
                       JOIN koch ON koch.kochid = g.kochid
                       WHERE b.bestellungid = ?";
        
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
        $sql = "SELECT b.bestellungid,
                       kunde.kundeid,
                       kunde.name,
                       kunde.vorname,
                       g.gekochtesgerichtid,
                       r.rezeptid,
                       r.name,
                       koch.kochid,
                       koch.name,
                       koch.vorname,
                       b.zeitpunkt,
                       b.preis,
                       b.zahlungsart
                       FROM " . $this->tabelle . " b 
                       JOIN kunde ON kunde.kundeid = b.kundeid
                       JOIN gekochtesgericht g ON g.gekochtesgerichtid = b.gekochtesgerichtid
                       JOIN rezept r ON r.rezeptid = g.rezeptid
                       JOIN koch ON koch.kochid = g.kochid
                       ORDER BY b.bestellungid";
        
        $this->baueBestellungTabelle($sql);
    }


    /* Tabellenbau Funktion */
    private function baueBestellungTabelle($sql) {
        // Verbindung zur Datenbank herstellen
        require("../config/db.inc.php");

        // Prepared Statement verwenden, um SQL-Injection zu verhindern
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->execute();
            // die Ergibisse an PHP-Variablen binden
            $stmt->bind_result($bestellungid,
                               $kundeid,
                               $kundeName,
                               $kundeVorname,
                               $gekochtesgerichtid,
                               $rezeptid,
                               $rezeptName,
                               $kochid,
                               $kochName,
                               $kochVorname,
                               $zeitpunkt,
                               $preis,
                               $zahlungsart);

            // Tabelle bauen
            echo "<div class=\"table-wrapper\">";
            echo "<table id=\"zebra\">\n";
            echo "<thead>
                    <tr>
                        <th>Nummer</th><th>Kunde</th><th>Gericht</th><th>Koch</th><th>Zeit</th><th>Preis(EUR)</th><th>Zahlungsart</th><th>Bearbeiten</th>
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
                . htmlspecialchars($bestellungid)
                ."</td>\n\t<td>"
                . htmlspecialchars($kundeVorname . " " . $kundeName)
                ."</td>\n\t<td>"
                . htmlspecialchars($rezeptName)
                ."</td>\n\t<td>"
                . htmlspecialchars($kochVorname . " " . $kochName)
                ."</td>\n\t<td>"
                . htmlspecialchars($zeitpunkt)
                ."</td>\n\t<td>"
                . htmlspecialchars($preis)
                ."</td>\n\t<td>"
                . htmlspecialchars($zahlungsart)
                ."</td>\n\t<td>"
                ."<a href=\"bestellungbearbeiten.php?bestellungid=" .htmlspecialchars($bestellungid) ."\">bearbeiten</a>"
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
    public function einfSelect($tab, $wert, $def, $text1 = null, $text2 = null) {
        // Verbindung zur Datenbank herstellen
        require("../config/db.inc.php");
    
        // Überprüfe, ob die Verbindung erfolgreich hergestellt wurde.
        if (!isset($mysqli)) {
            die("Datenbankverbindung konnte nicht hergestellt werden."); // Fehlerbehandlung ist wichtig!
        }
    
        // HTML-Code für das <select>-Element erstellen
        $s = "<select name=\"" . $wert . "\" id=\"" . $wert . "\">";
    
        // SQL-Befehl erstellen
        $sql = "SELECT " . $wert;
    
        // Only include text1 and/or text2 in the query if they are provided
        if ($text1) {
            $sql .= ", " . $text1;
        }
        if ($text2) {
            $sql .= ", " . $text2;
        }
        
        $sql .= " FROM " . $tab;
    
        // Prepared Statement vorbereiten
        if ($stmt = $mysqli->prepare($sql)) {
            // SQL-Befehl ausführen
            $stmt->execute();
    
            // Ergebnisvariablen an die Spalten binden
            if ($text1 && $text2) {
                $stmt->bind_result($wert, $text1, $text2);
            } elseif ($text1) {
                $stmt->bind_result($wert, $text1);
            } elseif ($text2) {
                $stmt->bind_result($wert, $text2);
            } else {
                $stmt->bind_result($wert); // Only bind the value if no text columns are needed
            }
    
            // Durch die Ergebnisse der Abfrage iterieren
            while ($stmt->fetch()) {
                // Build the display name based on available text columns
                $fullName = '';
                if ($text1 && $text2) {
                    $fullName = $text1 . " " . $text2;
                } elseif ($text1) {
                    $fullName = $text1;
                } elseif ($text2) {
                    $fullName = $text2;
                }
    
                // Option für jeden Datensatz erstellen
                $s = $s . "<option value=\"" . $wert . "\"";
    
                // überprüfen, ob der aktuelle Wert dem Standardwert entspricht
                if ($wert == $def) {
                    $s = $s . " selected";  // Option als vorausgewählt markieren
                }
    
                // Text der Option hinzufügen
                $s = $s . ">" . htmlspecialchars($fullName) . "</option>";
            }
    
            // Das </select>-Tag schließen
            $s = $s . "</select>";
    
            // Das generierte Dropdown-Menü zurückgeben
            return $s;
        } else {
            // Fehlerfall: Prepared Statement konnte nicht erstellt werden
            return false;
        }
    }
    

    /* Daten von rezept und koch anhand der gekochtesgerichtid holen */
    public function getRezeptKochByGekochtes($id) {
        // Verbindung zur Datenbank herstellen
        require("../config/db.inc.php");

        // SQL-Befehl zur Auswahl des Rezepts und Kochs für ein gekochtes Gericht
        $sql = "SELECT rezept.name AS rezept_name, 
                       koch.name AS koch_name, 
                       koch.vorname AS koch_vorname
                       FROM gekochtesgericht g
                       JOIN rezept ON rezept.rezeptid = g.rezeptid
                       JOIN koch ON koch.kochid = g.kochid
                       WHERE g.gekochtesgerichtid = ?";

        // Prepared Statement erstellen
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('i', $id);

            // SQL-Abfrage ausführen
            if (!$stmt->execute()) {
                error_log("Fehler bei der SQL-Ausführung: " . $stmt->error);
                return null;
            }

            // Ergebnis abrufen
            $stmt->bind_result($rezept_name, $koch_name, $koch_vorname);
            if ($stmt->fetch()) {
                $stmt->close();
                $mysqli->close(); 
                return ["rezept_name" => $rezept_name, "koch_fullname" => $koch_vorname . " " . $koch_name];
            }
            // Falls kein Ergebnis gefunden wurde, Statement schließen
            $stmt->close();
        } else {
            // Falls das Prepared Statement nicht erstellt werden konnte
            error_log("Fehler beim Erstellen des Statements: " . $mysqli->error);
        }

        // Verbindung schließen
        $mysqli->close();
        
        // Falls kein passender Eintrag gefunden wurde, null zurückgeben
        return null;
       
    }
}
?>