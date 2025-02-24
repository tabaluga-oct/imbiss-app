# Imbissverwaltung

## Projektbeschreibung
**Imbissverwaltung** ist ein Restaurant-Management-System für Admins.
Es ermöglicht die Verwaltung von **Koch**, **Kunde**, **Rezept**, **Gekochtes Gericht** und **Bestellung**.

## 📌 Features
- ✅ Admin-Login & Logout
- ✅ Verwaltung von **Koch**, **Kunde**, **Rezept**, **Gekochtes Gericht** und **Bestellung**
- ✅ MySQL-Datenbankintegration
- ✅ OOP
- ✅ Navigation mit Buttons
- ✅ DDL & DML SQL-Befehle enthalten

## 🛠️ Technologien
- **Frontend:** HTML, CSS
- **Backend:** PHP, JavaScript
- **Datenbank:** MySQL
- **Session Handling:** Admin-Authentifizierung

## 🚀 Installation
### Voraussetzungen
- **XAMPP** oder ähnlicher lokaler Server

### Schritte
1. Projekt herunterladen oder klonen
2. Verschiebe es in `htdocs/` (XAMPP)
3. **Apache & MySQL** starten
4. Erstelle die Datenbank:
   - Option 1: imbissverwaltung.sql in **phpMyAdmin** importieren
   - Option 2: Im Browser http://localhost/imbissverwaltung/config/db_erstellen.php ausführen
5. `config/db.inc.php` mit DB-Zugangsdaten anpassen
6. `http://localhost/koch/` im Browser öffnen

## 📂 Projektstruktur
project: Imbissverwaltung
│-- /assets (Bilder, styles.css)
│-- /config (Datenbankverbindung, Session-Handling)
│-- /diagram (Domänenmodell, Physisches Modell)
│-- /includes (Login/Logout-Skripte)
│-- /pages (PHP-Hauptseiten)
│-- /sql (Datenbank-Import und -Export)
│-- index.php (Haupteinstiegspunkt)

## 🔄 Zukünftige Erweiterungen
- 🔹 Mehrere Admins mit Rollen
- 🔹 Modernes UI mit Bootstrap
- 🔹 Preistabelle für gekochte Gerichte erstellen
- 🔹 Gesamtsumme der Bestellungen berechnen(inkl. MwSt.)

## 📌 Fazit
Dieses Projekt bietet praktische Erfahrung mit **PHP OOP**, **MySQL** und **Session Handling**. Herausforderungen lagen vor allem in der korrekten Umsetzung der **Datenbankbeziehungen**. Mögliche Verbesserungen sind eine modernere Benutzeroberfläche und erweiterte CRUD-Funktionalität.