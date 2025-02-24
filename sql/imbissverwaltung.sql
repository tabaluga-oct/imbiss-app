/*
Relational Datenbank für Imbissverwaltung in den Adminbereich
Tabellen: Koch, Kunde, Rezept, GekochtesGericht, Bestellung
*/

-- Sichere SQL-Modi setzen, um unerwartete Verhaltensweisen zu vermeiden
SET SQL_MODE = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION';
-- CET, UTC +, Winterzeit
SET time_zone = '+01:00';  -- +02:00 Sommerzeit

-- Standard-Zeichensatz und Kollation für UTF-8-Unterstützung setzen
-- UTF8MB4 unterstützt Emojis und alle Sonderzeichen besser als UTF8
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET collation_connection = 'utf8mb4_general_ci';

-- Standard-Speicher-Engine auf InnoDB setzen (falls noch nicht aktiv)
-- InnoDB ist besser für Transaktionen und Datenintegrität
SET default_storage_engine = InnoDB;

-- Prüfen, ob die Verbindung wirklich InnoDB als Standard nutzt
SHOW VARIABLES LIKE 'default_storage_engine';

-- Sicherstellen, dass Auto-Inkrement nicht einfach durch NULL oder 0 zurückgesetzt wird
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- die Datenbank erstellen
CREATE DATABASE IF NOT EXISTS imbissverwaltung
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE imbissverwaltung;

--  ------------------------------------------------------------------------------------

-- Tabellenstruktur für Tabelle 'Koch'

CREATE TABLE IF NOT EXISTS koch (
    kochid INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(40) NOT NULL,
    vorname VARCHAR(40) DEFAULT NULL,
    anzahl_von_sternen TINYINT DEFAULT NULL,
    koch_alter INT DEFAULT NULL,
    geschlecht ENUM('m', 'w', 'd') DEFAULT NULL,
    spezialgebiet VARCHAR(40) DEFAULT NULL,
    PRIMARY KEY (kochid)
);

-- Daten für Tabelle 'koch'

INSERT INTO koch (name, vorname, anzahl_von_sternen, koch_alter, geschlecht, spezialgebiet) VALUES
('Gordon', 'Ramsay', 5, 57, 'm', 'Hauptspeisen'),
('Jamie', 'Oliver', 4, 48, 'm', 'Italienische Küche'),
('Nigella', 'Lawson', 3, 64, 'w', 'Desserts'),
('Anthony', 'Bourdain', 4, 61, 'm', 'Internationale Küche'),
('Julia', 'Child', 5, 91, 'w', 'Französische Küche'),
('Wolfgang', 'Puck', 4, 74, 'm', 'Kalifornische Küche'),
('Emeril', 'Lagasse', 3, 64, 'm', 'Kreolische Küche'),
('Martha', 'Stewart', 4, 82, 'w', 'Desserts'),
('Yotam', 'Ottolenghi', 4, 55, 'm', 'Vegetarisch'),
('Masaharu', 'Morimoto', 5, 68, 'm', 'Japanische Küche'),
('Tim', 'Mälzer', 4, 49, 'm', 'Hauptspeisen'),
('Sarah', 'Wiener', 3, 35, 'w', 'Vegan'),
('Nelson', 'Müller', 5, 50, 'm', 'Hauptspeisen'),
('Cornelia', 'Poletto', 4, 62, 'w', 'Desserts'),
('Johann', 'Lafer', 4, 66, 'm', 'Österreichische Küche'),
('Susi', 'Mayer', 3, 42, 'w', 'Suppen');


-- Tabellenstruktur für Tabelle 'Kunde'

CREATE TABLE IF NOT EXISTS kunde (
    kundeid INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(40) NOT NULL,
    vorname VARCHAR(40) DEFAULT NULL,
    email VARCHAR(40) DEFAULT NULL,
    lieblingsgericht VARCHAR(40) DEFAULT NULL,
    plz VARCHAR(5) DEFAULT NULL,
    ort VARCHAR(40) DEFAULT NULL,
    strasse VARCHAR(40) DEFAULT NULL,
    strassenr VARCHAR(10) DEFAULT NULL,
    telefonnr VARCHAR(15) DEFAULT NULL,
    PRIMARY KEY (kundeid)
);

-- Daten für die Tabelle 'kunde'

INSERT INTO kunde (name, vorname, email, lieblingsgericht, plz, ort, strasse, strassenr, telefonnr) VALUES
('Müller', 'Anna', 'anna.mueller@example.com', 'Pizza Margherita', '10115', 'Berlin', 'Hauptstr.', '12', '017612345678'),
('Schmidt', 'Thomas', 'thomas.schmidt@example.com', 'Sushi', '80331', 'München', 'Bahnhofstr.', '5', '0891234567'),
('Fischer', 'Maria', 'maria.fischer@example.com', 'Schnitzel', '50667', 'Köln', 'Domstr.', '22', '0221123456'),
('Weber', 'Johannes', 'johannes.weber@example.com', 'Pasta Carbonara', '20095', 'Hamburg', 'Alsterweg', '8', '0409876543'),
('Becker', 'Lisa', 'lisa.becker@example.com', 'Tacos', '70173', 'Stuttgart', 'Königstr.', '15', '0711123456'),
('Hoffmann', 'Stefan', 'stefan.hoffmann@example.com', 'Burger', '01067', 'Dresden', 'Altmarkt', '9', '0351123456'),
('Schwarz', 'Kathrin', 'kathrin.schwarz@example.com', 'Currywurst', '90402', 'Nürnberg', 'Rathausplatz', '3', '0911123456'),
('Wagner', 'Andreas', 'andreas.wagner@example.com', 'Falafel', '04109', 'Leipzig', 'Brühl', '11', '0341123456'),
('Krause', 'Sophie', 'sophie.krause@example.com', 'Lasagne', '60311', 'Frankfurt', 'Zeil', '7', '0691123456'),
('Bauer', 'Max', 'max.bauer@example.com', 'Ratatouille', '99084', 'Erfurt', 'Domplatz', '4', '0361123456');

-- Tabellenstruktur für Tabelle 'rezept'

CREATE TABLE IF NOT EXISTS rezept (
    rezeptid INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(40) NOT NULL,
    dauer INT DEFAULT NULL,  -- Dauer in Minuten
    speiseart VARCHAR(40) DEFAULT NULL,
    rezeptbeschreibung TEXT DEFAULT NULL,
    PRIMARY KEY (rezeptid)
);

-- Daten für die Tabelle 'rezept'

INSERT INTO rezept (name, dauer, speiseart, rezeptbeschreibung) VALUES
('Spaghetti Bolognese', 45, 'Hauptgericht', 'Hackfleisch mit Tomatensauce und Pasta.'),
('Caesar Salad', 20, 'Vorspeise', 'Römersalat mit Caesar-Dressing und Croutons.'),
('Apfelstrudel', 60, 'Dessert', 'Blätterteig gefüllt mit Äpfeln, Zimt und Zucker.'),
('Ratatouille', 50, 'Hauptgericht', 'Geschmortes Gemüse mit Kräutern der Provence.'),
('Minestrone', 40, 'Suppe', 'Italienische Gemüsesuppe mit Nudeln und Bohnen.'),
('Wiener Schnitzel', 30, 'Hauptgericht', 'Paniertes Kalbsschnitzel mit Kartoffelsalat.'),
('Tiramisu', 35, 'Dessert', 'Mascarponecreme mit Löffelbiskuits und Kaffee.'),
('Hühnersuppe', 90, 'Suppe', 'Klare Brühe mit Hühnerfleisch und Gemüse.'),
('Sushi', 60, 'Hauptgericht', 'Reis mit rohem Fisch und Algenblättern.'),
('Pizza Margherita', 25, 'Hauptgericht', 'Teig mit Tomatensauce, Mozzarella und Basilikum.');


-- Tabellenstruktur für Tabelle 'gekochtesgericht'

CREATE TABLE IF NOT EXISTS gekochtesgericht (
    gekochtesgerichtid INT NOT NULL AUTO_INCREMENT,
    kochid INT DEFAULT NULL,
    rezeptid INT DEFAULT NULL,
    PRIMARY KEY (gekochtesgerichtid),
    FOREIGN KEY (kochid) REFERENCES koch(kochid) ON DELETE CASCADE,
    FOREIGN KEY (rezeptid) REFERENCES rezept(rezeptid) ON DELETE CASCADE
);

-- Daten für Tabelle 'gekochtesgericht'

INSERT INTO gekochtesgericht (kochid, rezeptid) VALUES
(1, 3),  -- Gordon Ramsay kocht Apfelstrudel
(2, 6),  -- Jamie Oliver kocht Wiener Schnitzel
(3, 7),  -- Nigella Lawson macht Tiramisu
(4, 2),  -- Anthony Bourdain macht Caesar Salad
(5, 4),  -- Julia Child kocht Ratatouille
(6, 9),  -- Wolfgang Puck macht Sushi
(7, 5),  -- Emeril Lagasse macht Minestrone
(8, 8),  -- Martha Stewart kocht Hühnersuppe
(9, 1),  -- Yotam Ottolenghi macht Spaghetti Bolognese
(10, 10); -- Masaharu Morimoto macht Pizza Margherita

-- -- Tabellenstruktur für Tabelle 'gekochtesgericht'

CREATE TABLE IF NOT EXISTS bestellung (
    bestellungid INT NOT NULL AUTO_INCREMENT,
    kundeid INT DEFAULT NULL,
    gekochtesgerichtid INT DEFAULT NULL,
    zeitpunkt DATETIME DEFAULT Null,
    preis DECIMAL(6, 2) DEFAULT NULL,
    zahlungsart VARCHAR(40) DEFAULT NULL,
    PRIMARY KEY (bestellungid),
    FOREIGN KEY (kundeid) REFERENCES kunde(kundeid) ON DELETE CASCADE,
    FOREIGN KEY (gekochtesgerichtid) REFERENCES gekochtesgericht(gekochtesgerichtid) ON DELETE CASCADE
);

-- Daten für dir Tabelle 'bestellung'

INSERT INTO bestellung (kundeid, gekochtesgerichtid, zeitpunkt, preis, zahlungsart) VALUES
(1, 2, '2025-02-13 12:30:00', 15.50, 'Kreditkarte'),
(2, 3, '2025-02-13 13:00:00', 18.75, 'PayPal'),
(3, 1, '2025-02-13 13:30:00', 12.30, 'Bargeld'),
(4, 5, '2025-02-13 14:00:00', 20.00, 'Kreditkarte'),
(5, 4, '2025-02-13 14:30:00', 17.40, 'Überweisung'),
(6, 6, '2025-02-13 15:00:00', 19.60, 'Kreditkarte'),
(7, 7, '2025-02-13 15:30:00', 22.10, 'PayPal'),
(8, 8, '2025-02-13 16:00:00', 16.90, 'Bargeld'),
(9, 9, '2025-02-13 16:30:00', 14.50, 'Kreditkarte'),
(10, 10, '2025-02-13 17:00:00', 21.00, 'Überweisung');

-- Tabellenstruktur für Tabelle 'admin'

CREATE TABLE IF NOT EXISTS admin (
    admin_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,  -- Store hashed passwords
    PRIMARY KEY (admin_id)
);

-- Insert default admin user only if it does not exist
INSERT INTO admin (username, password)  
SELECT 'pepsi', '$2y$10$x4RBSqZlvLqVLd8uSODRJ.KzJDptg/JFs0SqixMGqUIJSk28ugGPe'
WHERE NOT EXISTS (SELECT 1 FROM admin WHERE username = 'pepsi');
