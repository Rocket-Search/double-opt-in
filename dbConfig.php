<?php
$conn=mysqli_connect("localhost", "<USER>", "PassW0rd!", "double_opt_in");

if(!$conn)
{
die("Connection failed: " . mysqli_connect_error());
}

?>