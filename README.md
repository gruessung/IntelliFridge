# IntelliFridge
IntelliFridge ist ein kleines Warenwirtschaftssystem für den privaten Kühlschrank.

## Aktueller Stand
- EAN wird in Produktnamen übersetzt
- Bestand ist eintragbar über EAN

## Funktionen in Planung
- Menge pro Artikel eingebar, zB Milch in 1-Liter, Mehl in 500g
- WebInterface zur Verwaltung
- Statistiken zur Auswertung
- HandyApp für Abfrage des aktuellen Bestands

## Anleitung
- SQLite mit einem Editor leeren, da Testdaten enthalten sind
- php5-readline und php5-sqlite installieren
- <code>php read.php</code> ausführen
- EAN eingeben (Modi wechseln nicht vergessen)

## Modi
- 00 = Warenausgabe (Standard)
- 01 = Wareneingabe

## Screenshots
![Konsolenausgabe](http://img.gruessung.eu/?f=1435328301.png)

## License
MIT
