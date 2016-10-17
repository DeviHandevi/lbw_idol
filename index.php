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
function getFacebookFollowers() {
    $numberOfFollowers = "124K";
    return $numberOfFollowers;
}

function getTwitterFollowers() {
    $numberOfFollowers = "312K";
    return $numberOfFollowers;
}

	//function getTwitterFollowers($screenName = 'wpbeginner') {
	/*
	$follow_count = file_get_contents('count_twitter.php');
	echo $follow_count;
	$data = json_decode($follow_count, true);
	echo $data;
	$followers_count = $data['followers_count'];
	//echo $followers_count;
	*/

/*
function getTwitterFollowers($screenName = 'wpbeginner') {
    // some variables
    $consumerKey = 'YOUR_CONSUMER_KEY';
    $consumerSecret = 'YOUR_CONSUMER_SECRET';
    $token = get_option('cfTwitterToken');
 
    // get follower count from cache
    $numberOfFollowers = get_transient('cfTwitterFollowers');
 
    // cache version does not exist or expired
    if (false === $numberOfFollowers) {
        // getting new auth bearer only if we don't have one
        if(!$token) {
            // preparing credentials
            $credentials = $consumerKey . ':' . $consumerSecret;
            $toSend = base64_encode($credentials);
 
            // http post arguments
            $args = array(
                'method' => 'POST',
                'httpversion' => '1.1',
                'blocking' => true,
                'headers' => array(
                    'Authorization' => 'Basic ' . $toSend,
                    'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
                ),
                'body' => array( 'grant_type' => 'client_credentials' )
            );
 
            add_filter('https_ssl_verify', '__return_false');
            $response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);
 
            $keys = json_decode(wp_remote_retrieve_body($response));
 
            if($keys) {
                // saving token to wp_options table
                update_option('cfTwitterToken', $keys->access_token);
                $token = $keys->access_token;
            }
        }
        // we have bearer token wether we obtained it from API or from options
        $args = array(
            'httpversion' => '1.1',
            'blocking' => true,
            'headers' => array(
                'Authorization' => "Bearer $token"
            )
        );
 
        add_filter('https_ssl_verify', '__return_false');
        $api_url = "https://api.twitter.com/1.1/users/show.json?screen_name=$screenName";
        $response = wp_remote_get($api_url, $args);
 
        if (!is_wp_error($response)) {
            $followers = json_decode(wp_remote_retrieve_body($response));
            $numberOfFollowers = $followers->followers_count;
        } else {
            // get old value and break
            $numberOfFollowers = get_option('cfNumberOfFollowers');
            // uncomment below to debug
            //die($response->get_error_message());
        }
 
        // cache for an hour
        set_transient('cfTwitterFollowers', $numberOfFollowers, 1*60*60);
        update_option('cfNumberOfFollowers', $numberOfFollowers);
    }
 
    return $numberOfFollowers;
}
*/
?>
