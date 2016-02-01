<?php
if(!isset($_SESSION)){session_start();}
error_reporting(0);
if ($_SESSION['seedroot']!==''){
	if (!isset($_SESSION[$_SESSION['seedroot']])){
		$_SESSION[$_SESSION['seedroot']]=Array();
	}
	
	$mysession=& $_SESSION[$_SESSION['seedroot']];

	
}
else
	{
		$mysession=& $_SESSION;
	}
$site_name='Clewn Date';
$title='Free and different dating service';
$site_slogan='Free and different dating service';
$site_footer='Copyright 2012-2016 '.$site_name.'. This service is provided as is, without any warranty.';
$meta_description="Free, noncommercial, different dating service";
	$ranges=array(1, 2, 3, 5, 10, 15, 20, 25, 30, 50, 100, 500, 1000, 3000, 5000, 8000, 12000, 15000, 'n/a');


?>
