<html>
<head>
	<title>Idol</title>
	<?php require_once('token.php');?>
	<link rel="stylesheet" type="text/css" href="design.css"/>
</head>
<body>
	<div>
		<!-- FACEBOOK GALLERY -->
		<div class="left_pane">
			awdawdawd
		</div>
		
		<!-- TWITTER TIMELINE AND FOLLOWERS -->
		<div class="right_pane">
			<div class="twitter_timeline">
				<!--<h3>Latest Tweets</h3>-->
				<a class="twitter-timeline" 
					href="https://twitter.com/ridwankamil"
					height="500">
					Tweets by fabric
				</a> 
				<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
			</div>
			<div class="followers">
				<div class="left_pane">
					<img src="Logo/facebook.png" alt="Facebook Logo" class="logo"><br/>
					<?php echo getFacebookFollowers(); ?>
				</div>
				<div class="right_pane">
					<img src="Logo/twitter.png" alt="Twitter Logo" class="logo"><br/>
					<?php echo getTwitterFollowers(); ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<?php


function getTwitterFollowers() {
	ini_set('display_errors', 1);
	require_once('TwitterAPIExchange.php');
	global $settings;
    $url = 'https://api.twitter.com/1.1/users/lookup.json';
	$getfield = '?screen_name=ridwankamil';
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);

	$response = $twitter->setGetfield($getfield)
				 ->buildOauth($url, $requestMethod)
				 ->performRequest();

	$json_data = json_decode($response, true);
	$followers_count = $json_data[0]['followers_count'];
	return getCount($followers_count);
}


function getFacebookFollowers() {
	########## Value buat tes ########################
	global $app_id;
	global $app_secret;
	
	$page_id = "163237587161404"; #ridwankamil
	##################################################
	
	#token yang digunakan untuk URL yang perlu access token
	$authToken = execUrl("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$app_id}&client_secret={$app_secret}");

	#URL profile fan page
	$page_url = "https://graph.facebook.com/{$page_id}";
	
	#Eksekusi cURL dengan URL value like dari fanpage
	$page_like = execUrl($page_url . "?fields=fan_count&{$authToken}");
	
	$page_raw = json_decode($page_like);
	return getCount($page_raw->fan_count);
}

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

function getCount($count = 0) {
	$mil = 1000000;
	$thou = 1000;
	
	if($count >= $mil) {
		return number_format((float)$count/$mil, 2, '.', '') ."M";
	} else if($count >= $thou) {
		return number_format((float)$count/$thou, 2, '.', '') ."K";
	} else {
		return $count;
	}
}
?>
