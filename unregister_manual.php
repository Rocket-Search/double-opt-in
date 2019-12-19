<!Doctype html>

<!--###########################################################################################################################################################-->
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="$1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--<link rel="stylesheet" type="text/css" href="style.css">-->
	<title>Register</title>
</head>
<body>
<!--###########################################################################################################################################################-->

<!--###########################################################################################################################################################-->
 <?php
	//echo "unregister manual";
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	//echo "ipaddress#".$ipaddress;
	//echo "<br/><br/>";
	$fqdn = gethostbyaddr("8.8.8.8");
	//echo "fqdn#".$fqdn;
	//echo "<br/><br/>";
	
	include('dbConfig.php');

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
	
	//Wenn auf "register gedrückt wurde###################
	if(isset($_POST['deregister']))
	{
		$sql = "update double_opt_in set datensatz_gaendert_am = '".$datensatz_geaendert_am."' , accepted_by_email = 'UNRGEISTRED_BY_MANUAL_FORM', geaendert_von_wem = 'unregister_manual.php; web form user', accept_terms_of_condition = 'NO', ip = '".$ipaddress."', fqdn = '".$fqdn."' where email = '".$_POST["email"]."';";
		//echo "SQL Query#".$sql;
		//echo "<br/><br/>";
		$result = $conn->query("SET NAMES 'utf8'");
		$result = $conn->query($sql);

		$conn->close();
		header('Location: unregistred-thank-you.html');
		
		//Email senden an Admin###################################################################################################################
		$empfaenger = "root@bit-devil.ddns.net";
		$betreff = "Unregister per WEB FORM MANUAL INFO";
		$from = "From: Rocket Search <root@rocketsearch.ddns.net>";
		$text = "EMAIL: ".$_POST["email"]."\n";
		mail($empfaenger, $betreff, $text, $from);
		//###################################################################################################################
	
	}
		
	

 ?>

 <!--###########################################################################################################################################################-->

<form action="unregister_manual.php" method="post" "> 

<label id="first">Email</label><br/>
<input type="text" name="email"><br/>

<button type="submit" name="deregister">deregistrieren</button>

</form>
<!--###########################################################################################################################################################-->