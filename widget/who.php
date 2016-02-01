<?php
error_reporting(0);
	if(!isset($_SESSION)){session_start();}
	$seedroot=$_SESSION['seedroot'];

	chdir('./../seed/');

	include ('who.php');


?>
