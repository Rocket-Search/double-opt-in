<!Doctype html>

<!--###########################################################################################################################################################-->
<html>
<head>
	<meta charset="utf-8">
	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<!--<meta name="description" content="$1">-->
	<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
	<!--<link rel="stylesheet" type="text/css" href="style.css">-->
	<?xml version="1.0" encoding="UTF-8"?>
	<title>Register</title>
</head>
<body>
<!--###########################################################################################################################################################-->

<!--###########################################################################################################################################################-->
 <?php
	//header("Content-Type: text/html;charset=UTF-8");
	header('Content-Type: text/html; charset=utf-8');

	include('dbConfig.php');

	//Wenn auf "register gedrückt wurde###################
	if(isset($_POST['send_message']))
	{
		//SQL Query Daten in DB schreiben###################################################################################
		//###################################################################################################################
		//$ipaddress = $_SERVER['REMOTE_ADDR'];				//reale IP wenn nicht hinter reverse proxy
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];		//reale IP vom reverse proxy
		//echo "ipaddress#".$ipaddress;
		//echo "<br/><br/>";
		$fqdn = gethostbyaddr($ipaddress);
		//$fqdn = gethostbyaddr("8.8.8.8");
		//echo "fqdn#".$fqdn;
		//echo "<br/><br/>";
		
		//Timestamp###############################################
		date_default_timezone_set("UTC");
		//echo "UTC:".time();
		//echo "<br>"; 

		date_default_timezone_set("Europe/Berlin");
		//echo "Europe/Berlin:".time();
		//echo "<br>";

		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
		//print $d->format("Y-m-d H:i:s.u"); // note at point on "u"
		$datensatz_erstellt_am = $d->format("Y-m-d H:i:s.u");
		//###############################################
		
		//SQL Query senden#################################################
		$sql = "INSERT INTO contacts (vorname, nachname, email_address, jobtitel, telefon, mobil,firma, plz, ort, strasse, hausnummer, accept_terms_of_condition, ip, fqdn, kundennummer_uuid, datensatz_erstellt_am, email_text ) VALUES ('".$_POST["vorname"]."','".$_POST["nachname"]."','".$_POST["email"]."','".$_POST["jobtitel"]."','".$_POST["telefon"]."','".$_POST["mobil"]."', '".$_POST["firma"]."','".$_POST["plz"]."','".$_POST["ort"]."','".$_POST["strasse"]."','".$_POST["hausnummer"]."','".$_POST["terms"]."','".$ipaddress."','".$fqdn."','".$kundennummer_uuid."','".$datensatz_erstellt_am."','".$_POST["text_message"]."')";
		//echo "sql# ".$sql;
		//echo "<br>";
		$result = mysqli_query($conn,"SET NAMES 'utf8'");		//UTF 8 für die DB
		$result = mysqli_query($conn,$sql);
		$conn->close();
		//###################################################################################################################
		
		//Danke Seite anzeihen###################################################################################
		header('Location: contact-thank-you.html');
		
		//Email senden###################################################################################
		// Absender, Empfänger und Betreff kodieren
		$abs     = '=?UTF-8?B?'.base64_encode('Rocket Search').'?=';
		$empf    = '=?UTF-8?B?'.base64_encode($_POST["vorname"].' '.$_POST["nachname"]).'?=';
		$betreff = '=?UTF-8?B?'.base64_encode('Email via Web Form bei rocketsearch').'?=';
		 // E-Mail Adressen anhängen
		$abs    .= ' <software.moore@gmail.com>';
		 // Header schreiben
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$header .= 'To: ' . $empf . "\r\n";
		$header .= 'From: ' . $abs . "\r\n";
		  // HTML-Nachricht schreiben
		$msg     = '<html><head><title>Email via Web Form bei rocketsearch</title></head>';
		$msg    .= '<body><p>'.$_POST["vorname"].' '.$_POST["nachname"].'</p> Hat eine Email per Web Form geschrieben  <br/><br/> Text: <br/><br/> '.$_POST["text_message"].'  </body></html>';
		//#
		mail("root@bit-devil.ddns.net", $betreff, $msg."<br/><br/>EMAIL:".$_POST["email"], $header);
		//###################################################################################################################
		
	}
?>
<!--###########################################################################################################################################################-->

<script type="text/javascript">

  function checkForm(form)
  {
    if(!form.terms.checked) {
      alert("Please indicate that you accept the Terms and Conditions");
      form.terms.focus();
      return false;
    }
    return true;
  }

</script>
<!--###########################################################################################################################################################-->

<form action="contact_form.php" method="post" accept-charset="utf-8" onsubmit="return checkForm(this);"> 

<label id="first">Vorname:</label><br/>
<input type="text" name="vorname"><br/>

<label id="first">Nachname</label><br/>
<input type="text" name="nachname"><br/>

<label id="first">Email</label><br/>
<input type="text" name="email"><br/>

<label id="first">Optional: Firma</label><br/>
<input type="text" name="firma"><br/>

<label id="first">Optional: Ort</label><br/>
<input type="text" name="ort"><br/>

<label id="first">Optional: Postleitzahl</label><br/>
<input type="text" name="plz"><br/>

<label id="first">Optional: Straße</label><br/>
<input type="text" name="strasse"><br/>

<label id="first">Optional: Hausnummer</label><br/>
<input type="text" name="hausnummer"><br/>

<label id="first">Optional: Telefonnummer</label><br/>
<input type="text" name="telefon"><br/>

<label id="first">Optional: Mobil</label><br/>
<input type="text" name="mobil"><br/>

<label id="first">Optional: Job Titel</label><br/>
<input type="text" name="jobtitel"><br/>

<label id="first">Nachricht</label><br/>
<textarea name="text_message" cols="40" rows="5"></textarea>

<!--###########################################################################################################################################################-->
<!--https://www.mein-datenschutzbeauftragter.de/datenschutzerklaerung-konfigurator/-->
<!--###########################################################################################################################################################-->


<p><strong><big>Datenschutzerklärung</big></strong></p>
<p><strong>Allgemeiner Hinweis und Pflichtinformationen</strong></p>
<p><strong>Benennung der verantwortlichen Stelle</strong></p>
<p>Die verantwortliche Stelle für die Datenverarbeitung auf dieser Website ist:</p>
<p><span id="s3-t-firma">Rocket-Search</span><br><span id="s3-t-ansprechpartner">Team RS</span><br><span id="s3-t-strasse">Hauptstraße 75</span><br><span id="s3-t-plz">68309</span> <span id="s3-t-ort">Mannheim</span></p><p></p>
<p>Die verantwortliche Stelle entscheidet allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten (z.B. Namen, Kontaktdaten o. Ä.).</p>

<p><strong>Widerruf Ihrer Einwilligung zur Datenverarbeitung</strong></p>
<p>Nur mit Ihrer ausdrücklichen Einwilligung sind einige Vorgänge der Datenverarbeitung möglich. Ein Widerruf Ihrer bereits erteilten Einwilligung ist jederzeit möglich. Für den Widerruf genügt eine formlose Mitteilung per E-Mail. Die Rechtmäßigkeit der bis zum Widerruf erfolgten Datenverarbeitung bleibt vom Widerruf unberührt.</p>

<p><strong>Recht auf Beschwerde bei der zuständigen Aufsichtsbehörde</strong></p>
<p>Als Betroffener steht Ihnen im Falle eines datenschutzrechtlichen Verstoßes ein Beschwerderecht bei der zuständigen Aufsichtsbehörde zu. Zuständige Aufsichtsbehörde bezüglich datenschutzrechtlicher Fragen ist der Landesdatenschutzbeauftragte des Bundeslandes, in dem sich der Sitz unseres Unternehmens befindet. Der folgende Link stellt eine Liste der Datenschutzbeauftragten sowie deren Kontaktdaten bereit: <a href="https://www.bfdi.bund.de/DE/Infothek/Anschriften_Links/anschriften_links-node.html" target="_blank">https://www.bfdi.bund.de/DE/Infothek/Anschriften_Links/anschriften_links-node.html</a>.</p>

<p><strong>Recht auf Datenübertragbarkeit</strong></p>
<p>Ihnen steht das Recht zu, Daten, die wir auf Grundlage Ihrer Einwilligung oder in Erfüllung eines Vertrags automatisiert verarbeiten, an sich oder an Dritte aushändigen zu lassen. Die Bereitstellung erfolgt in einem maschinenlesbaren Format. Sofern Sie die direkte Übertragung der Daten an einen anderen Verantwortlichen verlangen, erfolgt dies nur, soweit es technisch machbar ist.</p>

<p><strong>Recht auf Auskunft, Berichtigung, Sperrung, Löschung</strong></p>
<p>Sie haben jederzeit im Rahmen der geltenden gesetzlichen Bestimmungen das Recht auf unentgeltliche Auskunft über Ihre gespeicherten personenbezogenen Daten, Herkunft der Daten, deren Empfänger und den Zweck der Datenverarbeitung und ggf. ein Recht auf Berichtigung, Sperrung oder Löschung dieser Daten. Diesbezüglich und auch zu weiteren Fragen zum Thema personenbezogene Daten können Sie sich jederzeit über die im Impressum aufgeführten Kontaktmöglichkeiten an uns wenden.</p>

<p><strong>SSL- bzw. TLS-Verschlüsselung</strong></p>
<p>Aus Sicherheitsgründen und zum Schutz der Übertragung vertraulicher Inhalte, die Sie an uns als Seitenbetreiber senden, nutzt unsere Website eine SSL-bzw. TLS-Verschlüsselung. Damit sind Daten, die Sie über diese Website übermitteln, für Dritte nicht mitlesbar. Sie erkennen eine verschlüsselte Verbindung an der „https://“ Adresszeile Ihres Browsers und am Schloss-Symbol in der Browserzeile.</p>

<p><strong>Server-Log-Dateien</strong></p>
<p>In Server-Log-Dateien erhebt und speichert der Provider der Website automatisch Informationen, die Ihr Browser automatisch an uns übermittelt. Dies sind:</p>
<ul>
    <li>Besuchte Seite auf unserer Domain</li>
    <li>Datum und Uhrzeit der Serveranfrage</li>
    <li>Browsertyp und Browserversion</li>
    <li>Verwendetes Betriebssystem</li>
    <li>Referrer URL</li>
    <li>Hostname des zugreifenden Rechners</li>
    <li>IP-Adresse</li>
</ul>
<p>Es findet keine Zusammenführung dieser Daten mit anderen Datenquellen statt. Grundlage der Datenverarbeitung bildet Art. 6 Abs. 1 lit. b DSGVO, der die Verarbeitung von Daten zur Erfüllung eines Vertrags oder vorvertraglicher Maßnahmen gestattet.</p>
            
<p><strong>Datenübermittlung bei Vertragsschluss für Warenkauf und Warenversand</strong></p>
<p>Personenbezogene Daten werden nur an Dritte nur übermittelt, sofern eine Notwendigkeit im Rahmen der Vertragsabwicklung besteht. Dritte können beispielsweise Bezahldienstleister oder Logistikunternehmen sein. Eine weitergehende Übermittlung der Daten findet nicht statt bzw. nur dann, wenn Sie dieser ausdrücklich zugestimmt haben.</p>
<p>Grundlage für die Datenverarbeitung ist Art. 6 Abs. 1 lit. b DSGVO, der die Verarbeitung von Daten zur Erfüllung eines Vertrags oder vorvertraglicher Maßnahmen gestattet.</p>
            
<p><strong>Kontaktformular</strong></p>
<p>Per Kontaktformular übermittelte Daten werden einschließlich Ihrer Kontaktdaten gespeichert, um Ihre Anfrage bearbeiten zu können oder um für Anschlussfragen bereitzustehen. Eine Weitergabe dieser Daten findet ohne Ihre Einwilligung nicht statt.</p>
<p>Die Verarbeitung der in das Kontaktformular eingegebenen Daten erfolgt ausschließlich auf Grundlage Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Ein Widerruf Ihrer bereits erteilten Einwilligung ist jederzeit möglich. Für den Widerruf genügt eine formlose Mitteilung per E-Mail. Die Rechtmäßigkeit der bis zum Widerruf erfolgten Datenverarbeitungsvorgänge bleibt vom Widerruf unberührt.</p>
<p>Über das Kontaktformular übermittelte Daten verbleiben bei uns, bis Sie uns zur Löschung auffordern, Ihre Einwilligung zur Speicherung widerrufen oder keine Notwendigkeit der Datenspeicherung mehr besteht. Zwingende gesetzliche Bestimmungen - insbesondere Aufbewahrungsfristen - bleiben unberührt.</p>
            
<p><strong>Newsletter-Daten</strong></p>
<p>Zum Versenden unseres Newsletters benötigen wir von Ihnen eine E-Mail-Adresse. Eine Verifizierung der angegebenen E-Mail-Adresse ist notwendig und der Empfang des Newsletters ist einzuwilligen. Ergänzende Daten werden nicht erhoben oder sind freiwillig.
	Die Verwendung der Daten erfolgt ausschließlich für den Versand des Newsletters.</p>
<p>Die bei der Newsletteranmeldung gemachten Daten werden ausschließlich auf Grundlage Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO) verarbeitet. Ein Widerruf Ihrer bereits erteilten Einwilligung ist jederzeit möglich. Für den Widerruf genügt eine formlose
	Mitteilung per E-Mail oder Sie melden sich über den "Austragen"-Link im Newsletter ab. Die Rechtmäßigkeit der bereits erfolgten Datenverarbeitungsvorgänge bleibt vom Widerruf unberührt.</p>
<p>Zur Einrichtung des Abonnements eingegebene Daten werden im Falle der Abmeldung gelöscht. Sollten diese Daten für andere Zwecke und an anderer Stelle an uns übermittelt worden sein, verbleiben diese weiterhin bei uns.</p>
            
<p><strong>Cookies</strong></p>
<p>Unsere Website verwendet Cookies. Das sind kleine Textdateien, die Ihr Webbrowser auf Ihrem Endgerät speichert. Cookies helfen uns dabei, unser Angebot nutzerfreundlicher, effektiver und sicherer zu machen. </p>
<p>Einige Cookies sind “Session-Cookies.” Solche Cookies werden nach Ende Ihrer Browser-Sitzung von selbst gelöscht. Hingegen bleiben andere Cookies auf Ihrem Endgerät bestehen, bis Sie diese selbst löschen. Solche Cookies helfen uns, Sie bei Rückkehr auf
	unserer Website wiederzuerkennen.</p>
<p>Mit einem modernen Webbrowser können Sie das Setzen von Cookies überwachen, einschränken oder unterbinden. Viele Webbrowser lassen sich so konfigurieren, dass Cookies mit dem Schließen des Programms von selbst gelöscht werden. Die Deaktivierung von Cookies
	kann eine eingeschränkte Funktionalität unserer Website zur Folge haben.</p>
<p>Das Setzen von Cookies, die zur Ausübung elektronischer Kommunikationsvorgänge oder der Bereitstellung bestimmter, von Ihnen erwünschter Funktionen (z.B. Warenkorb) notwendig sind, erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Als Betreiber dieser
	Website haben wir ein berechtigtes Interesse an der Speicherung von Cookies zur technisch fehlerfreien und reibungslosen Bereitstellung unserer Dienste. Sofern die Setzung anderer Cookies (z.B. für Analyse-Funktionen) erfolgt, werden diese in dieser
	Datenschutzerklärung separat behandelt.</p>
            
<p><strong>Google Analytics</strong></p>
<p>Unsere Website verwendet Funktionen des Webanalysedienstes Google Analytics. Anbieter des Webanalysedienstes ist die Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA.</p>
<p>Google Analytics verwendet "Cookies." Das sind kleine Textdateien, die Ihr Webbrowser auf Ihrem Endgerät speichert und eine Analyse der Website-Benutzung ermöglichen. Mittels Cookie erzeugte Informationen über Ihre Benutzung unserer Website
	werden an einen Server von Google übermittelt und dort gespeichert. Server-Standort ist im Regelfall die USA.</p>
<p>Das Setzen von Google-Analytics-Cookies erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Als Betreiber dieser Website haben wir  ein berechtigtes Interesse an der Analyse des Nutzerverhaltens, um unser Webangebot und ggf. auch Werbung zu optimieren.</p>
<p>IP-Anonymisierung</p>
<p>Wir setzen Google Analytics in Verbindung mit der Funktion IP-Anonymisierung ein. Sie gewährleistet, dass Google Ihre IP-Adresse innerhalb von Mitgliedstaaten der Europäischen Union oder in anderen Vertragsstaaten des Abkommens über den Europäischen Wirtschaftsraum
	vor der Übermittlung in die USA kürzt. Es kann Ausnahmefälle geben, in denen Google die volle IP-Adresse an einen Server in den USA überträgt und dort kürzt. In unserem Auftrag wird Google diese Informationen benutzen, um Ihre Nutzung der Website
	auszuwerten, um Reports über Websiteaktivitäten zu erstellen und um weitere mit der Websitenutzung und der Internetnutzung verbundene Dienstleistungen gegenüber uns zu erbringen. Es findet keine Zusammenführung der von Google Analytics übermittelten
	IP-Adresse mit anderen Daten von Google statt.</p>
<p>Browser Plugin</p>
<p>Das Setzen von Cookies durch Ihren Webbrowser ist verhinderbar. Einige Funktionen unserer Website könnten dadurch jedoch eingeschränkt werden. Ebenso können Sie die Erfassung von Daten bezüglich Ihrer Website-Nutzung einschließlich Ihrer IP-Adresse mitsamt
	anschließender Verarbeitung durch Google unterbinden. Dies ist möglich, indem Sie das über folgenden Link erreichbare Browser-Plugin herunterladen und installieren: <a href="https://tools.google.com/dlpage/gaoptout?hl=de">https://tools.google.com/dlpage/gaoptout?hl=de</a>.</p>
<p>Widerspruch gegen die Datenerfassung</p>
<p>Sie können die Erfassung Ihrer Daten durch Google Analytics verhindern, indem Sie auf folgenden Link klicken. Es wird ein Opt-Out-Cookie gesetzt, der die Erfassung Ihrer Daten bei zukünftigen Besuchen unserer Website verhindert: Google Analytics deaktivieren.</p>
<p>Einzelheiten zum Umgang mit Nutzerdaten bei Google Analytics finden Sie in der Datenschutzerklärung von Google: <a href="https://support.google.com/analytics/answer/6004245?hl=de">https://support.google.com/analytics/answer/6004245?hl=de</a>.</p>
<p>Auftragsverarbeitung</p>
<p>Zur vollständigen Erfüllung der gesetzlichen Datenschutzvorgaben haben wir mit Google einen Vertrag über die Auftragsverarbeitung abgeschlossen.</p>
<p>Demografische Merkmale bei Google Analytics</p>
<p>Unsere Website verwendet die Funktion “demografische Merkmale” von Google Analytics. Mit ihr lassen sich Berichte erstellen, die Aussagen zu Alter, Geschlecht und Interessen der Seitenbesucher enthalten. Diese Daten stammen aus interessenbezogener Werbung
	von Google sowie aus Besucherdaten von Drittanbietern. Eine Zuordnung der Daten zu einer bestimmten Person ist nicht möglich. Sie können diese Funktion jederzeit deaktivieren. Dies ist über die Anzeigeneinstellungen in Ihrem Google-Konto möglich oder
	indem Sie die Erfassung Ihrer Daten durch Google Analytics, wie im Punkt “Widerspruch gegen die Datenerfassung” erläutert, generell untersagen.</p>
            
<p><strong>PayPal</strong></p>
<p>Unsere Website ermöglicht die Bezahlung via PayPal. Anbieter des Bezahldienstes ist die PayPal (Europe) S.à.r.l. et Cie, S.C.A., 22-24 Boulevard Royal, L-2449 Luxembourg.</p>
<p>Wenn Sie mit PayPal bezahlen, erfolgt eine Übermittlung der von Ihnen eingegebenen Zahlungsdaten an PayPal.</p>
<p>Die Übermittlung Ihrer Daten an PayPal erfolgt auf Grundlage von Art. 6 Abs. 1 lit. a DSGVO (Einwilligung) und Art. 6 Abs. 1 lit. b DSGVO (Verarbeitung zur Erfüllung eines Vertrags). Ein Widerruf Ihrer bereits erteilten Einwilligung ist jederzeit möglich.
	In der Vergangenheit liegende Datenverarbeitungsvorgänge bleiben bei einem Widerruf wirksam.</p>



</br></br>
</br></br>
<input type="checkbox" name="terms" >Ich aktzeptiere die Datenschutzerklärung<br>
</br></br>
</br></br>
<button type="submit" name="send_message">Abesenden</button>

</form>
<!--###########################################################################################################################################################-->

</body>
</html>