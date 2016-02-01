<?php
error_reporting(0);

session_start();


$seedroot='date.clewn.org';

$_SESSION['seedroot']=$seedroot;

chdir('./../seed/');

include ('./index.php');




?>
