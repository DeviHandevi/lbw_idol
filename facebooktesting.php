<?php
	
	/*
		Page_id
		Coldplay = 15253175252
	*/
	
	session_start();
	
	#method untuk request isi URL secara GET
	function execUrl($url){
		
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		
		$result_data = curl_exec($ch);
		curl_close($ch);
		
		return $result_data;
	}
	
	#method untuk mengecek jenis error dari json
	function jsonDebug(){
		switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }
	}
	########## Value buat tes ########################
	$app_id = '1093523087427893';
	$app_secret = '5531f9ef82beb33889e2faf467c6f23e';
	
	$page_id = "163237587161404";
	##################################################
	
	#token yang digunakan untuk URL yang perlu access token
	$authToken = execUrl("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$app_id}&client_secret={$app_secret}");

	#URL profile fan page
	$page_url = "https://graph.facebook.com/{$page_id}";
	
	#Eksekusi cURL dengan URL value profile dari fanpage
	$page_profile = execUrl($page_url . "?{$authToken}");
	
	#get dan sout dari value profile
	$page_raw = json_decode($page_profile);
	echo $page_raw->name . "<br>";
	
	#Eksekusi cURL dengan URL value like dari fanpage
	$page_like = execUrl($page_url . "?fields=fan_count&{$authToken}");
	
	#get dan sout dari value like
	$page_raw = json_decode($page_like);
	echo $page_raw->fan_count;
	
	#Eksekusi cURL dengan URL value json dari timeline fan page
	$page_feed = execUrl($page_url . "/feed?{$authToken}");

	#Eksekusi cURL dengan URL value alamat profile picture dari fan page
	$page_picture = execUrl($page_url . "/picture?width=140&height=110&redirect=false");
	
	#get dan sout dari value profile picture
	$pict = json_decode($page_picture);
	echo "<img src = '{$pict->data->url}' />";
	
	#get dan sout dari value json timeline
	$feedarray = json_decode($page_feed);
	$count = 0;
	foreach ( $feedarray->data as $feed_data )
	{
		$count = $count + 1;
		echo "<h2>{$feed_data->message}</h2><br />";
		echo "{$feed_data->created_time}<br /><br />";
		echo "{$feed_data->id}<br /><br />";
		if($count == 5){
			break;
		}
	}
	
	$page_album = execUrl($page_url . "/albums?{$authToken}");
	$albumarray = json_decode($page_album);
	jsonDebug();
	$album_id = "";
	foreach ( $albumarray->data as $album_data )
	{
		if($album_data->name == "Timeline Photos"){
			$album_id = $album_data->id;
			break;
		}
		/* echo "{$album_data->name}<br />";
		echo "{$album_data->id}<br /><br />"; */
	}
	echo $album_id;
?>
