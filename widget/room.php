<?php
	if(!isset($_SESSION)){session_start();}
	$seedroot=$_SESSION['seedroot'];

	chdir('./../seed/');

	include ('room.php');


?>
