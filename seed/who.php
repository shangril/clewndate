<?php if(!isset($_SESSION)){session_start();}
include('site_variables.php');

include ('header_functs.php');

if (isset($mysession['nick'])&&trim($mysession['nick'])===''){
	
	session_unset();
}

if (isset($_GET['vote'])){
	$vote=$_GET['vote'];
	$votenick=$_GET['nick'];
	$votecolor=$_GET['color'];
	
	if ($vote==='love'){
		$mysession['vote'][$votenick][$votecolor]=true;
	}
	else if ($vote==='dislike'){
		$mysession['vote'][$votenick][$votecolor]=false;
		
	}else
	{
			unset($mysession['vote'][$votenick][$votecolor]);
	}
	
	
}

if (isset($_GET['changed'])&&isset($_GET['value'])) {
	$keys=Array ('sex', 'seek', 'age');
	if (in_array($_GET['changed'], $keys)){
		$mysession[$_GET['changed']]=$_GET['value'];
		
	}
	else if ($_GET['changed']=='pic'&&isset($_POST['hidden'])) {
		$dossier = './'.$seedroot.'/u/';
		$fichier = basename($_FILES['torrent']['name']);
		$taille_maxi = 6000000;
		$taille = filesize($_FILES['torrent']['tmp_name']);
		$extensions = array('.jpeg','.jpg','.JPG');
		$fichier=str_replace('.php', '', $fichier);

		if($taille>$taille_maxi)
		{
			 $erreur = 'We do not accept file bigger than 6 megabytes';
		}
		if(!isset($erreur)) 
		{	$ts=microtime(true);
			if(move_uploaded_file($_FILES['torrent']['tmp_name'], $dossier . $ts.'.jpg'))
			 {
				  $mysession['pic']=$ts.'.jpg';
			 }
			 else
			 {
				  echo 'Sorry, the system encountered an error';
				  die();

			 }
		}
		else
		{
			 echo $erreur;
			 die();
		}
		
		
	}
}
if (!isset($_GET['count'])){

?>
<html>
<head>
	<?php if (!isset($_GET['change'])){
			echo '<meta http-equiv="refresh" content="12;">';
		}?>
<style>
	a {
		color:black;
		text-decoration:none;
		}
</style>
<link rel="stylesheet" href="../style.css" type="text/css" media="screen" />

<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="charset" content="utf-8"/>

</head>
<body id="bod">
<?php

if (isset($_GET['change'])){
		if ($_GET['change']=='nick'){
			echo ' <form action="./" target="_parent" method="POST"><input type="text" name="nick" value="'.htmlspecialchars($mysession['nick']).'"/><input value="✅" type="submit"/></form>';

 
			
		}
		else if ($_GET['change']=='sex'){
			echo ' <form action="./who.php"  method="GET"><input type="hidden" name="changed" value="sex"/><select name="value">';
			$keys=Array('⚲','♀','♂', '⚥');
			foreach ($keys as $i){
					echo '<option value="'.$i.'">'.$i.'</option>';
				
			}
			echo '</select><input value="✅" type="submit"/></form>';

 
			
		}
		else if ($_GET['change']=='seek'){
			echo ' <form action="./who.php"  method="GET"><input type="hidden" name="changed" value="seek"/><select name="value">';
			$keys=Array('⚲','♀','♂', '⚥', '♀♂', '♀⚥', '♂⚥', '✘');
			foreach ($keys as $i){
					echo '<option value="'.$i.'">'.$i.'</option>';
				
			}
			echo '</select><input value="✅" type="submit"/></form>';

 
		}
		else if ($_GET['change']=='age'){
			echo ' <form action="./who.php"  method="GET"><input type="hidden" name="changed" value="age"/><select name="value"><option value="n/a">n/a</option>';
			for ($i=18;$i<=120;$i++){
					echo '<option value="'.$i.'">'.$i.'</option>';
				
			}
			echo '</select><input value="✅" type="submit"/></form>';

 
			
		}
		else if ($_GET['change']=='pic'){
			echo '<form id="picform" action="./who.php?changed=pic&value=file"  enctype="multipart/form-data" method="POST"><input name="torrent" type="file" accept="image/jpeg"/><input name="hidden" type="hidden" value="hidden"/><input value="✅" onclick="document.getElementById(\'picform\').style.display=\'none\';document.getElementById(\'uploading\').innerHTML=(\'uploading...\');" type="submit"/></form><div id="uploading"></div>';
		}
	
	echo '</body>';
	die();
}
if (isset($_GET['hide'])){
	if ($_GET['hide']==='hide'){
		$_SESSION['hide']=true;
	}
	else{
		unset($_SESSION['hide']);
	}
}
if (!isset($_SESSION['hide'])){
	
	echo '<div style="width:100%;text-align:center;"><a href="./who.php?hide=hide">▲</a></div>';
	echo '<div style="background-color:#FFCFDE;"><span style="float:left;width:50%;">';
	echo '<strong style="'.$mysession['color'].'"><a href="./who.php?change=nick">'.htmlspecialchars($mysession['nick']).'</a></strong><br/>';
	echo '<a class="bigtext" href="./who.php?change=sex">'.htmlspecialchars($mysession['sex']).'</a> ';
	echo '<a class="bigtext" href="./who.php?change=age">'.htmlspecialchars($mysession['age']).'</a><br/>';
	echo '<a href="./?norange=true" target="_parent">';
	if ($mysession['lat']!=3000){
		echo '0';
		}
	else {
		echo 'n/a';
	}
	echo ' kms</a>';


	echo '<a class="bigtext" href="./who.php?change=seek">'.htmlspecialchars($mysession['seek']).'</a>';


	echo '</span>';

	if (!$mysession['pic']){
		echo ' <a href="./who.php?change=pic"><span class="picquestion"> ? </span></a> ';
		
	}
	else {
		echo '<a href="./who.php?change=pic"><img class="profilepic" src="/thumbnailer.php?target='.urlencode($mysession['pic']).'"/></a>';

		
	}

	echo '</div><hr style="clear:both;"/>';
}
else
{
	echo '<div style="width:100%;text-align:center;"><a href="./who.php?hide=show">▼</a></div><hr/>';
	
}
$blacklist=Array();
$blacklist[$mysession['nick']][$mysession['color']]=true;



} else {
	$args=Array('long', 'lat', 'range');
	foreach ($args as $arg){

		$mysession[$arg]=$_GET[$arg];
	
	}
	$mysession['norange']=false;
	$seedroot=str_replace ('./', '', $_GET['seedroot']);
}
if (isset($_GET['private_nick'])&&isset($_GET['private_sid'])) {
	$showonlymessages=true;
	$displaynone=true;
}


$nicklist=Array();


$files=scandir('./'.$seedroot.'/e');
rsort($files);
$keys=array();
foreach ($files as $fil)
{
		$data=file_get_contents('./'.$seedroot.'/e/'.$fil);
		$dat=unserialize($data);
		$goonbaby=true;
		if (true){
			$messagesfiles=scandir('./'.$seedroot.'/f');
			sort($messagesfiles);
			$msgcount=0;
			foreach ($messagesfiles as $privatefile){
					$datap=file_get_contents('./'.$seedroot.'/f/'.$privatefile);
					$datp=unserialize($datap);
					if (
							(
								(
									($datp['to']['nick']===$mysession['nick']&&
									$datp['to']['color']===$mysession['color']&&
									$datp['from']['nick']===$dat['nick']&&
									$datp['from']['color']===$dat['color'])								
								)
							)
					
					
						
					
						){
							$lastseentimestamp=0;
							if (isset($mysession['seen_private'][$datp['from']['nick']][$datp['from']['color']])){
								$lastseentimestamp=$mysession['seen_private'][$datp['from']['nick']][$datp['from']['color']];
				
							}

								if(floatval(str_replace('.php', '', $privatefile))>$lastseentimestamp){

									$msgcount++;
								
							
							}
							
					
				}
				
			}
			if ($msgcount<=0&&$showonlymessages){
				$goonbaby=false;
			}
		}
		
		
		
		
		
		if($goonbaby&&$dat &&	$keys[$dat['color']][$dat['nick']]!==true &&
				(
						(($mysession['range']==='n/a'&&$dat['range']==='n/a')||
						($mysession['norange']==true&&$dat['range']==='n/a')||
						($mysession['range']==='n/a'&&$dat['norange']==true)||
						($mysession['norange']==true&&$dat['norange']==true)||
						($dat['norange']==true&&$mysession['range']==='n/a')||
						($dat['range']==='n/a'&&$mysession['range']==='n/a')||
						($dat['norange']==true&&$mysession['norange']==true)||
						($dat['range']=='n/a'&&$mysession['norange']==true)
						
						)
						||
						($dat['norange']!==true&&$mysession['norange']!==true&&($mysession['range']!=='n/a'&&$dat['range']!=='n/a')
						&&
								
				((floatval($mysession['range'])/111.12)> sqrt(pow(floatval($mysession['long'])-floatval($dat['long']),2)+pow(floatval($mysession['lat'])-floatval($dat['lat']),2))) && ((floatval($dat['range'])/111.12)> sqrt(pow(floatval($dat['long'])-floatval($mysession['long']),2)+pow(floatval($dat['lat'])-floatval($mysession['lat']),2)))
						
						
						)
				)
				
				&&!isset($blacklist[$dat['nick']][$dat['color']])
				)


		{
			$output='';
			if (isset($dat['vote'][$mysession['nick']][$mysession['color']])&&$dat['vote'][$mysession['nick']][$mysession['color']]){
				$output.='<span style="float:left;color:red;border-radius 4px;text-align:center;">♥</span>';
			
			}
			if ($msgcount>0){
				$output.='<span style="float:left;background-color:red;color:white;border-radius 4px;text-align:center;">✉'.htmlspecialchars($msgcount).'</span>';
			}
			if (isset($dat['vote'][$mysession['nick']][$mysession['color']])&&$dat['vote'][$mysession['nick']][$mysession['color']]===true){
				
				$msgcount=$msgcount+10000;
			}
			if (isset($dat['vote'][$mysession['nick']][$mysession['color']])&&$dat['vote'][$mysession['nick']][$mysession['color']]===false){
				
				$msgcount=$msgcount-10000;
			}
			$output.='<div style="background-color:#FFEFFE;"><span style="float:left;width:50%;">';

			$output.='<strong style="'.$dat['color'].'"><a style="color:black;text-decoration:none;" target="_parent" href="./?private_nick='.urlencode($dat['nick']).'&private_sid='.urlencode($dat['color']).'">'.htmlspecialchars($dat['nick']).'</a></strong><br/>';
			$distance=floor(sqrt(pow(floatval($mysession['long'])-floatval($dat['long']),2)+pow(floatval($mysession['lat'])-floatval($dat['lat']),2))/111.12);
			$output.='<span class="bigtext">'.htmlspecialchars($dat['sex']).'</span> ';
			$output.='<span class="bigtext">'.htmlspecialchars($dat['age']).'</span><br/>';

			if ($mysession['norange']!==true&&$dat['norange']!==true) {
			
			$output.=htmlspecialchars($distance);
			}
		else {$output.= 'n/a';}
			
			
			$output.= ' kms';
			$output.='<span class="bigtext">'.htmlspecialchars($dat['seek']).'</span>';

			$output.='</span>';
			if (!$dat['pic']){
				$output.='<span class="picquestion"> ? </span>';
	
			}
			else {
				$output.='<a target="new" href="../seed/'.$seedroot.'/u/'.urlencode($dat['pic']).'"><img class="profilepic" src="/thumbnailer.php?target='.urlencode($dat['pic']).'"/></a>';

	
			}
			
			if (!isset($mysession['vote'][$dat['nick']][$dat['color']])){
				
				$output.='<span style="float:right"><a href="./who.php?vote=love&nick='.urlencode($dat['nick']).'&color='.urlencode($dat['color']).'">♥</a><a href="./who.php?vote=dislike&nick='.urlencode($dat['nick']).'&color='.urlencode($dat['color']).'">✘</a></span>';


			}
			else if ($mysession['vote'][$dat['nick']][$dat['color']]){
				
				$output.='<span style="float:right"><a href="./who.php?vote=neutral&nick='.urlencode($dat['nick']).'&color='.urlencode($dat['color']).'">♥</a></span>';
			
			}
			else {
				
				$output.='<span style="float:right"><a href="./who.php?vote=neutral&nick='.urlencode($dat['nick']).'&color='.urlencode($dat['color']).'">✘</a></span>';
			
			}
			
			
			
			$output.='</div><hr style="clear:both;"/>';		
			
			
			
			$keys[$dat['color']][$dat['nick']]=true;
			$nicklist[$msgcount][$dat['nick'].$dat['color']]=$output;
			}
	
	
	
}


echo '<hr/>';
krsort($nicklist);
if (!isset($_GET['count'])){
	foreach ($nicklist as $nickcount){
		$nicks=array_keys($nickcount);
		
		foreach ($nicks as $nick){
			echo $nickcount[$nick];
		}
	}
}
else {
	$count=0;
		foreach ($nicklist as $nickcount){
		$nicks=array_keys($nickcount);
		
		foreach ($nicks as $nick){
			$count++;
		}
	}

	echo $count;
	die();
}
?>
</body>


</html>
