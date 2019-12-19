CREATE TABLE `double_opt_in` (
	`vorname` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`nachname` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`email` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`jobtitel` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`telefon` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`mobil` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`firma` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`plz` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`ort` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`strasse` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`hausnummer` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`accept_terms_of_condition` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`ip` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`fqdn` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`kundennummer_uuid` VARCHAR(50) NOT NULL DEFAULT '00-00-00-00-00' COLLATE 'utf8_unicode_ci',
	`register_email_link` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`accepted_by_email` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`datensatz_erstellt_am` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`datensatz_gaendert_am` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`geaendert_von_wem` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	PRIMARY KEY (`kundennummer_uuid`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
;
