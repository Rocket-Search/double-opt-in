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
	
	
	//$sql = "select * from double_opt_in where register_email_link = 'http://double.moore.corp/registermail.php?TyAOjLZiohmGAnJwP5W6YDMqHnUa27Pf5317EfXKVDxWjxyyZZ';";
	$sql = "update double_opt_in set datensatz_gaendert_am = '".$datensatz_geaendert_am."' , accepted_by_email = 'UNRGEISTRED_BY_EMAIL_LINK', geaendert_von_wem = 'unregister.php; email_von_user_link', accept_terms_of_condition = 'NO', ip = '".$ipaddress."', fqdn = '".$fqdn."' where kundennummer_uuid = '".$email_link_string."';";
	//echo "SQL Query#".$sql;
	//echo "<br/><br/>";
	$result = $conn->query("SET NAMES 'utf8'");
	$result = $conn->query($sql);

	$conn->close();

	echo "Erfolgreich deregistriet";
	
	//Email an root zur Inof
	//Email senden an Admin###################################################################################################################
	$empfaenger = "root@bit-devil.ddns.net";
	//echo "empfaenger#".$empfaenger;
	$betreff = "Unregister per Email LINK INFO";
	$from = "From: Rocket Search <root@rocketsearch.ddns.net>";
	$text = "DE REGISTER Kundennummer(UUID): ".$email_link_string."\n";
	mail($empfaenger, $betreff, $text, $from);
	//###################################################################################################################
?>
<!--###########################################################################################################################################################-->



</body>
</html>