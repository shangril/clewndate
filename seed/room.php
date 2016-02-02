<?php  if(!isset($_SESSION)){session_start();}
include('site_variables.php');

$_SESSION['chans'][$seedroot]=microtime(true);
include ('header_functs.php');
?>
<html>
<head>
<meta http-equiv="refresh" content="3">
<link rel="stylesheet" href="../style.css" type="text/css" media="screen" />

<style>a link 
{
color:black;
text-decoration:none;
}</style>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="charset" content="utf-8"/>

</head>
<body id="bod">
<?php
	$data['long']=$mysession['long'];
	$data['lat']=$mysession['lat'];
	$data['nick']=$mysession['nick'];
	$data['range']=$mysession['range'];
	$data['color']=$mysession['color'];
	$data['init']=$mysession['init'];
	$data['norange']=$mysession['norange'];
	$data['sex']=$mysession['sex'];
	$data['seek']=$mysession['seek'];
	$data['age']=$mysession['age'];
	$data['pic']=$mysession['pic'];
	if (!isset($mysession['vote'])){
		$mysession['vote']=Array();
	}
	$data['vote']=$mysession['vote'];

	$dat=serialize($data);
	file_put_contents('./'.$seedroot.'/e/'.microtime(true).'.php', $dat);

//update pic

$ts=microtime(true);

if ($mysession['pic']!==false && 
		(
		(floatval(str_replace('.jpg', '', $mysession['pic']))+2900)<microtime(true)
		
		)

		){
	if (copy ('./'.$seedroot.'/u/'.$mysession['pic'],'./'.$seedroot.'/u/'.$ts.'.jpg')) {
		$mysession['pic']=$ts.'.jpg';
	}
	
}



//clean up that mess
$files=scandir('./'.$seedroot.'/f');
sort($files);
foreach ($files as $fil)
{
	if (strstr($fil, '.php')&&floatval(str_replace('.php','',$fil))<microtime(true)-3000)
	{
		unlink('./'.$seedroot.'/f/'.$fil);
		}
}


$files=scandir('./'.$seedroot.'/e');
sort($files);
foreach ($files as $fil)
{
	if (strstr($fil, '.php')&&floatval(str_replace('.php','',$fil))<microtime(true)-15)
	{
		unlink('./'.$seedroot.'/e/'.$fil);
		}
}
$files=scandir('./'.$seedroot.'/d');
sort($files);
foreach ($files as $fil)
{
	if (strstr($fil, '.php')&&floatval(str_replace('.php','',$fil))<microtime(true)-3000)
	{
		unlink('./'.$seedroot.'/d/'.$fil);
		}
	}
$files=scandir('./'.$seedroot.'/u');
sort($files);
foreach ($files as $fil)
{
	if (strstr($fil, '.jpg')&&floatval(str_replace('.jpg','',$fil))<microtime(true)-3000)
	{
		unlink('./'.$seedroot.'/u/'.$fil);
		}
}


//main logic

$target='d';
$private=false;
if(isset($_GET['private_nick'])&&isset($_GET['private_sid'])){
	$target='f';
	$private=true;
	$mysession['seen_private'][$_GET['private_nick']][$_GET['private_sid']]=microtime(true);
	$files=array_diff(scandir('./'.$seedroot.'/e/'), Array ('.', '..'));
	
	$pic=false;
	
	foreach ($files as $file){
		$dat=unserialize(file_get_contents('./'.$seedroot.'/e/'.$file));
		if ($dat['nick']===$_GET['private_nick']
			&&$dat['color']===$_GET['private_sid']) {
				
				$pic=true;
				
			}
	}
	if (!$pic){
		echo '◀◍</body></html';
		die();
		
	}



}

$files=scandir('./'.$seedroot.'/'.$target);
sort($files);
foreach ($files as $fil)
{
	if (strstr($fil, '.php')&&floatval(str_replace('.php','',$fil))>floatval($mysession['zero']))
	{
		$data=file_get_contents('./'.$seedroot.'/'.$target.'/'.$fil);
		$dat=unserialize($data);
		$goonbaby=true;
		
		if ($private){
			if (!
					(
						(
							($dat['to']['nick']===$mysession['nick']&&
							$dat['to']['color']===$mysession['color']&&
							$dat['from']['nick']===$_GET['private_nick']&&
							$dat['from']['color']===$_GET['private_sid'])
							||
							($dat['from']['nick']===$_GET['private_nick']&&
							$dat['from']['color']===$_GET['private_sid']&&
							$dat['to']['nick']===$mysession['nick']&&
							$dat['to']['color']===$mysession['color'])
						)
						||
						(
							($dat['from']['nick']===$mysession['nick']&&
							$dat['form']['color']===$mysession['color']&&
							$dat['to']['nick']===$_GET['private_nick']&&
							$dat['to']['color']===$_GET['private_sid'])
							||
							($dat['to']['nick']===$_GET['private_nick']&&
							$dat['to']['color']===$_GET['private_sid']&&
							$dat['from']['nick']===$mysession['nick']&&
							$dat['from']['color']===$mysession['color'])
						
						)
					)
				){
				$goonbaby=false;
				
			}
			
		}
		
		
		
		
		if ($goonbaby&&
				(
						($mysession['range']==='n/a'&&$dat['range']==='n/a')
						||
						(($dat['norange']!==true&&$mysession['norange']!==true&&($mysession['range']!=='n/a'&&$dat['range']!=='n/a'))
						&&
				
				((floatval($mysession['range'])/111.12)> sqrt(pow(floatval($mysession['long'])-floatval($dat['long']),2)+pow(floatval($mysession['lat'])-floatval($dat['lat']),2))) && ((floatval($dat['range'])/111.12)> sqrt(pow(floatval($dat['long'])-floatval($mysession['long']),2)+pow(floatval($dat['lat'])-floatval($mysession['lat']),2)))
						
	
						
						)
				)
				
				
				){
			$ts=floatval(str_replace('.php','',$fil));
			$ttl=3000-(microtime(true)-$ts);
			
			echo htmlspecialchars(round($ttl));
					
					
					
			echo ' &lt;<strong style="'.$dat['color'].'"><a style="color:black;text-decoration:none;" target="_parent" href="./?private_nick='.urlencode($dat['nick']).'&private_sid='.urlencode($dat['color']).'">'.htmlspecialchars($dat['nick']).'</a></strong> &gt; '.htmlspecialchars($dat['message']); 
			echo '<hr/>';
		}
	}
	
	
	
}
?>
<script content="text/javascript">
x = 0;  
y = document.getElementById('bod').scrollHeight; 
window.scroll(x,y);
</script>
</body>


</html>
