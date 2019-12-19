<!Doctype html>

<!--###########################################################################################################################################################-->
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="$1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--<link rel="stylesheet" type="text/css" href="style.css">-->
	<title>Register by mail</title>
</head>
<body>
<!--###########################################################################################################################################################-->

<!--###########################################################################################################################################################-->
<?php
	//ini_set('display_errors', 'On');
	//error_reporting(E_ALL);
	
	//echo $_GET['q'];  //Output: myquery
	//echo $_SERVER['QUERY_STRING']
	$email_link_string = $_SERVER['QUERY_STRING'];
	//echo "email_link_string#".$email_link_string;
	//echo "<br/><br/>";
	
	include('dbConfig.php');

	//$ipaddress = $_SERVER['REMOTE_ADDR'];				//reale IP wenn nicht hinter reverse proxy
	$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];		//reale IP vom reverse proxy
	//echo "ipaddress#".$ipaddress;
	//echo "<br/><br/>";
	//$fqdn = gethostbyaddr("8.8.8.8");
	$fqdn = gethostbyaddr($ipaddress);
	//echo "fqdn#".$fqdn;
	//echo "<br/><br/>";
	
	//$sql = "select * from double_opt_in where register_email_link = 'http://double.moore.corp/registermail.php?TyAOjLZiohmGAnJwP5W6YDMqHnUa27Pf5317EfXKVDxWjxyyZZ';";
	//$sql = "select * from double_opt_in where register_email_link = 'http://double.moore.corp/registermail.php?".$email_link_string."';";
	$sql = "select * from double_opt_in where register_email_link = 'http://register.ddns.net/registermail.php?".$email_link_string."';";
	//echo "SQL Query#".$sql;
	//echo "<br/><br/>";
	//$result = mysqli_query($conn,$sql);
	
	//$result = mysqli_query($conn,"SET NAMES 'utf8'");
	$result = $conn->query("SET NAMES 'utf8'");

	$result = $conn->query($sql);
	if ($result->num_rows > 0) 
	{
		// output data of each row
		while($row = $result->fetch_assoc())
		{
			//echo $row["vorname"];
			//echo $row["register_email_link"];
			//echo "<br/><br/>";
			//echo "<br/><br/>";
			//echo $row["email"];
			
			//$email_link_gleich_link_in_db = strcasecmp($row["register_email_link"], 'http://double.moore.corp/registermail.php?'.$email_link_string);
			$email_link_gleich_link_in_db = strcasecmp($row["register_email_link"], 'http://register.ddns.net/registermail.php?'.$email_link_string);
						
			if ($email_link_gleich_link_in_db == 0)
			{
				echo "Die Registrierung ist nun abgeschlossen";
				echo "<br/>";
			
				header('Location: contact-thank-you.html');
				//Email senden###################################################################################################################
				// Absender, Empfänger und Betreff kodieren
				//$abs     = '=?UTF-8?B?'.base64_encode('Rocket Search').'?=';
				$abs     = 'Rocket Search';
				//$empf    = '=?UTF-8?B?'.base64_encode($row["vorname"].' # '.$row["nachname"]).'?=';
				$empf    = $row["vorname"].' '.$row["nachname"];
				//echo $row["vorname"].' # '.$row["nachname"];
				$betreff = '=?UTF-8?B?'.base64_encode('Registrierung bei rocketsearch.ddns.net ABGESCHLOSSEN').'?=';
				 // E-Mail Adressen anhängen
				$abs    .= ' <root@rocketsearch.ddns.net>';
				//$empf   .= ' <root@bit-devil.ddns.net>';
				$empf   .= ' <'.$row["email"].'>';
				 // Header schreiben
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$header .= 'To: ' . $empf . "\r\n";
				$header .= 'From: ' . $abs . "\r\n";
				  // HTML-Nachricht schreiben
				$msg     = '<html><head><title>Registrierung bei rocketsearch.ddns.net ABGESCHLOSSEN</title></head>';
				$msg    .= '<body><p>Hallo '.$row["vorname"].' '.$row["nachname"].'</p>Danke für die Registrierung <br/><br/> um sich zu deregistrieren bitte folgenden Link anklicken <a href="http://register.ddns.net/unregister.php?'.$row["kundennummer_uuid"].'">deregistrieren</a>  <br/><br/> Danke  </body></html>';
				 // Mail versenden
				mail("", $betreff, $msg, $header);
				//Copy of Mail to Admin
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				mail("root@bit-devil.ddns.net", $betreff, $msg."<br/><br/>EMAIL:".$row["email"], $header);
				//###################################################################################################################
			
			}
		
		}
	}
	else 
	{
		//echo "0 results";
		echo "Problem, bitte wenden sie sich an:<a href=\"mailto:root@rocketsearch.ddns.net\">root@rocketsearch.ddns.net</a>.";
	}
//$conn->close();

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
	$datensatz_geaendert_am = $d->format("Y-m-d H:i:s.u");
	//###############################################
			
	//Neue Verbindung mit Email Link IP Adresse und FQDN Accept_by_email in DB auy YES Datensatz geänder auf aktuelles datum und wer(email register php)
	//update double_opt_in set datensatz_gaendert_am = '456' where register_email_link = 'http://double.moore.corp/registermail.php?7CmkUu4yzzCeKaiMMJgXedF8h7xo83IWeWbwDIMPf04KzNgics';
	//$sql = "update double_opt_in set datensatz_gaendert_am = '".$datensatz_geaendert_am."' where register_email_link = 'http://double.moore.corp/registermail.php?".$email_link_string."';";
	$sql = "update double_opt_in set datensatz_gaendert_am = '".$datensatz_geaendert_am."' , accepted_by_email = 'YES', geaendert_von_wem = 'registermail.php; email_von_user' where register_email_link = 'http://register.ddns.net/registermail.php?".$email_link_string."';";
	echo "sql#".$sql;
	echo "<br>"; 
	$result = $conn->query($sql);

	$conn->close();

?>
<!--###########################################################################################################################################################-->



</body>
</html>