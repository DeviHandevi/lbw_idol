<html>
<head>
	<title>Idol</title>
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

	$settings = array(
		'oauth_access_token' => "",
		'oauth_access_token_secret' => "",
		'consumer_key' => "",
		'consumer_secret' => ""
	);

    $url = 'https://api.twitter.com/1.1/users/lookup.json';
	$getfield = '?screen_name=ridwankamil';
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);

	$response = $twitter->setGetfield($getfield)
				 ->buildOauth($url, $requestMethod)
				 ->performRequest();
				 
	$mil = 1000000;
	$thou = 1000;
	
	$json_data = json_decode($response, true);
	$followers_count = $json_data[0]['followers_count'];
	if($followers_count >= $mil) {
		return number_format((float)$followers_count/$mil, 2, '.', '') ."M";
	} else if($followers_count >= $thou) {
		return number_format((float)$followers_count/$thou, 2, '.', '') ."K";
	} else {
		return $followers_count;
	}
}


function getFacebookFollowers() {
    $numberOfFollowers = "124K";
    return $numberOfFollowers;
}
?>