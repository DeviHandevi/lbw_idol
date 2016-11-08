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
	global $app_id;
	global $app_secret;
	
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
	
	#ngambil foto dari album "Profile Picture" dengan batas 5 gambar
	$page_album = execUrl($page_url . "/albums?{$authToken}");
	$albumarray = json_decode($page_album);
	$profileAlbumID;
	$count = 0;
	foreach ( $albumarray->data as $album_data )
	{
		if($album_data->name == "Profile Pictures"){
			$profileAlbumID = $album_data->id;
			break;
		}
	}
	$page_photos = execUrl("https://graph.facebook.com/{$profileAlbumID}/photos?{$authToken}");
	$photoarray = json_decode($page_photos);
	$photoIDarray;
	$count = 0;
	foreach ( $photoarray->data as $photos_data )
	{
		if(($count > 0) && ($photos_data->id != $photoIDarray[$count-1])){
			$photoIDarray[$count] = $photos_data->id;
		}
		else if($count == 0){
			$photoIDarray[$count] = $photos_data->id;
		}
		$count = $count + 1;
		if($count == 5){
			break;
		}
	}
	$url_array;
	while($count > 0){
		$count = $count;
		$photos = execUrl("https://graph.facebook.com/{$photoIDarray[5-$count]}?fields=images&{$authToken}");
		$photos_array = json_decode($photos);
		foreach ($photos_array->images as $photo_images){
			$url_array[5-$count] = $photo_images->source;
			break;
		}
		$count = $count - 1;
	}
	for($i = 0; $i < count($url_array); $i++){
		echo "<img src='{$url_array[$i]}'/>";
	}
?>
