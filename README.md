"double opt in" process
gemäß Datenschutz Grundverordnung DSGVO/RGPD

https://github.com/Rocket-Search-Software/double-opt-in

Auf Basis von php, MariaDB, Apapche und Email versand.

Getestet mit php 7.1.5, Maria DB 10.1.23, Apache 2.4.25 und postfix 3.2.0

Einfach die gewünschent Werte wie Email Absender und Empfänger editieren, sowie
die Registrations URLs .

create_db.sql = SQL query zum Anlegen des DB Schema

dbConfig.php = Datenbankzugriff Konfiguration

index.php = Startseite für die Registrierung, dies in die normale Hompage integrieren.

registermail.php = Nimmt die Regitrierung per Email entgegen, verarbeitet diese in der DB und sende eine Email

unregister.php = Nimmt den Deregistrierung Link aus der Email entgegen

unregister_manual.php = Manuelle Deregistrierung mit Email als Refernez

contact-thank-you.html = Danke Seite für die Registrierung

unregistred-thank-you.html = Danke Seite für die deregistrierung

contact_form.php = Kontakt Web Form (losgelößt vom "double-ob-in" Prozess)
