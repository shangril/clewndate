<?php 

if (isset($_GET['logout'])&&!isset($_SESSION['logout'])){
	session_unset();
	$_SESSION['logout']=true;
	echo '<html><head><meta http-equiv="refresh" content="0"></head></html>';
	die();

	
}
if (isset($_POST['message'])){
	$target='d';
	
	$data['long']=$mysession['long'];
	$data['lat']=$mysession['lat'];
	$data['nick']=$mysession['nick'];
	$data['range']=$mysession['range'];
	$data['message']=$_POST['message'];
	$data['color']=$mysession['color'];
	$data['norange']=$mysession['norange'];
	
	if(isset($_GET['private_nick'])&&isset($_GET['private_sid'])){
			$target='f';
			$data['to']['nick']=$_GET['private_nick'];
			$data['to']['color']=$_GET['private_sid'];
			$data['from']['nick']=$mysession['nick'];
			$data['from']['color']=$mysession['color'];
			
	}
	
	
	$dat=serialize($data);
	file_put_contents('./'.$seedroot.'/'.$target.'/'.microtime(true).'.php', $dat);
	
	
}



if (!isset($mysession['range'])){

	$mysession['range']='n/a';

	
}
if (isset($_GET['range'])&&($_GET['range']==='n/a'||is_numeric($_GET['range']))){

	$mysession['range']=$_GET['range'];
	$mysession['zero']=microtime(true);
	
}




?>
<em><?php 
echo '<a href="./"><h2 style="display:inline;">'.htmlspecialchars($site_name).'</h2></a>';

?></em><?php
if (isset($_GET['private_nick'])&&isset($_GET['private_sid'])) {
	$mysession['seen_private'][$_GET['private_nick']][$_GET['private_sid']]=microtime(true);
	echo ' <span style="'.htmlspecialchars($_GET['private_sid']).'">';
	$files=array_diff(scandir('./'.$seedroot.'/e/'), Array ('.', '..'));
	
	$pic=false;
	
	foreach ($files as $file){
		$dat=unserialize(file_get_contents('./'.$seedroot.'/e/'.$file));
		if ($dat['nick']===$_GET['private_nick']
			&&$dat['color']===$_GET['private_sid']
			&&$dat['pic']!==false) {
				
				$pic=$dat['pic'];
				
			}
	}
	
	if($pic!==false){
		echo '<a target="new" href="../seed/'.$seedroot.'/u/'.urlencode($dat['pic']).'"><img class="privpic" src="/thumbnailer.php?target='.urlencode($dat['pic']).'"/></a> ';

		
	}
	
	echo ' '.htmlspecialchars($_GET['private_nick']).'</span>';	

	echo '<br/>';

}


if ($mysession['norange']!==true&&!isset($_GET['private_nick'])&&!isset($_GET['private_sid'])){
			?>
			<form method="GET" action="./" id="formrange" style="display:inline;">✈ <select onchange="document.getElementById('formrange').submit();" name="range">
		<?php
		foreach ($ranges as $range) {
			echo '<option value="'.$range.'" ';
			if ($range==$mysession['range']){
				echo 'selected';

				}
			echo ' >'.$range.' kms';
			echo '('.file_get_contents('http://date.clewn.org/widget/who.php?seedroot=date.clewn.org&count=count&lat='.urlencode($mysession['lat']).'&long='.urlencode($mysession['long']).'&range='.urlencode($range)).')';
			echo '</option>';
		}


		?>


		</select></form><a href="./">♻</a>

	
	<?php
}
?>
<br/>
<iframe style="display:inline;float:left;width:75%;height:380px;border:0px;" src="./room.php<?php 

	if (isset($_GET['private_nick'])&&isset($_GET['private_sid'])){
		echo '?private_nick='.urlencode($_GET['private_nick']).'&private_sid='.urlencode($_GET['private_sid']);
		
		
		
		
		}

?>"></iframe>
<iframe style="display:inline;float:left;width:25%;height:380px;border:0px;" src="./who.php<?php 

	if (isset($_GET['private_nick'])&&isset($_GET['private_sid'])){
		echo '?private_nick='.urlencode($_GET['private_nick']).'&private_sid='.urlencode($_GET['private_sid']);
		
	}

?>"></iframe>
<span style="clear:both;"></span>
<form style="display:inline;" action="./<?php 

	if (isset($_GET['private_nick'])&&isset($_GET['private_sid'])){
		echo '?private_nick='.urlencode($_GET['private_nick']).'&private_sid='.urlencode($_GET['private_sid']);
		
	}

?>" method="post"><a href="javascript:void(0)" onclick="this.nextSibling.focus();">✍ </a><input type="text" name="message" size="38"></input><input type="submit" value="✓"></input></form>
<?php
echo '<br/><a style="clear:both;float:right;" target="top" href="../?logout=true">◀◍</a><br/><span style="float:right;">';
echo generate_footer($site_footer);
?>
