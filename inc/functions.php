<?php

function HW_activate() {
}

function HW_deactivate(){
    delete_option( 'HW_Twitter_OAT' );
    delete_option( 'HW_Twitter_OATS' );
    delete_option( 'HW_Twitter_CK' );
    delete_option( 'HW_Twitter_CS' );
    delete_option( 'HW_default_hashtag' );
    delete_option( 'HW_debug_mode' );
}

function HW_uninstall(){
    HW_deactivate();
}

function searchTweetsByHashTag($hashtag, $json_decode = true){
    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    $settings = array(
        'oauth_access_token' => "1116721440789860352-u7CS4ZUgshQgs7Gi5G25h1WAhBsB8t",
        'oauth_access_token_secret' => "pVGne3p3rdMIKNcYawlnlQele04W2TCMzAgRV5vKOW2at",
        'consumer_key' => "MjpaJURndkpb1M8VHffvbsia1",
        'consumer_secret' => "ITQjZWd4w9as3qpnMhTbQtRs9RZZWUzMfKBVfE1w9P0gqwJN6U"
    );

    $settings = [
        'oauth_access_token' => get_option('HW_Twitter_OAT'),
        'oauth_access_token_secret' => get_option('HW_Twitter_OATS'),
        'consumer_key' => get_option('HW_Twitter_CK'),
        'consumer_secret' => get_option('HW_Twitter_CS'),
    ];
    
    /** Perform a GET request and echo the response **/
    /** Note: Set the GET field BEFORE calling buildOauth(); **/
    $url = 'https://api.twitter.com/1.1/search/tweets.json';
    if(!is_array($hashtag)){
        $getfield = "?q=#{$hashtag}&result_type=recent";
    }else{
        $getfield = "?" . http_build_query($hashtag, '', '&');
    }
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $response = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();

    if(!$json_decode) return $response;
    return json_decode($response, true);
}

function buildHtmlTemplateForTweet($tweet){
    $user = $tweet['user'];
    $user_name = $user['name'];
    $user_screen_name = $user['screen_name'];
    $user_screen_name = strtolower($user_screen_name);

    $user_image_url = $user['profile_image_url'];
    $user_image_url = str_replace("http:", "", $user_image_url);
    $user_image_url = str_replace("_normal.", ".", $user_image_url);

    // echo "<pre>"; print_r($tweet); die();
    $html = "
            <div class=\"feed feed_{$tweet['counter']}\">
				<div class=\"feed_details\">
                    <div class=\"thumb\">
                        <img src=\"{$user_image_url}\"  alt=\"{$user_name}\"/>
                    </div>
                    <div class=\"content\">
                        <div class=\"header\">
                            <span class=\"_name\">{$user_name}</span> 
                            <span class=\"fa fa-twitter\"></span>
                            <span class=\"header-subline\">@{$user_screen_name}</span>
                        </div>
                        <div class=\"message-text\">
                            <a target=\"_blank\" href=\"//twitter.com/{$user_screen_name}/statuses/{$tweet['id_str']}\">
                                {$tweet['full_text']}
                            </a>
                        </div>
                    </div>
                </div>				
                <div class=\"feed_image\" style=\"background-image: url({$user_image_url});\"></div>
            </div>
    ";
    
    return $html;
}

function searchAndBuildTweets($attr){
	//$hashtag = !empty($attr['hashtag']) ? $attr['hashtag'] : 'ihatecancer';
    $hashtag = get_option('HW_default_hashtag');
    
    if(HW_fs()->can_use_premium_code__premium_only()){
        if(!empty($attr['hashtag'])){
            $hashtag = $attr['hashtag'];
        }
    }
    
    $hashtag = str_replace('#', '', $hashtag);

	$hashtag = "#{$hashtag}";

    $results = searchTweetsByHashTag([
        'q' => $hashtag,
        'tweet_mode' => 'extended',
        'result_type' => 'recent',
        'count' => "120",
    ]);

    if(!empty($results['errors'])){
        if (get_option('HW_debug_mode') == 'true') {
            foreach ($results['errors'] as $error) {
                _dd($error['message']);
            }
        }else{
            _dd('Something went worng');
        }
        return;
    }

    $tweets = $results['statuses'];

    $html = '';
    $count = 0;
    $sub_counter = 0;
    $_html = '';
    while(count($tweets) < 120){
        $tweets = array_merge($tweets, $tweets);
    }
    if(count($tweets) > 120){        
        $tweets = array_slice($tweets, 0, 120, true);
    } 
    shuffle($tweets);
    $tweetLength = count($tweets);
    foreach ($tweets as $key => $tweet) {
        ++$count;
        ++$sub_counter;
        $tweet['counter'] = $sub_counter;
        $template = buildHtmlTemplateForTweet($tweet);

        $_html .= $template;

        if($count % 10 == 0 || $tweetLength==$count){
            $html .= "<div class=\"twitter_feeds_inner\">{$_html}</div>";
            $_html = '';
            $sub_counter = 0;
        }
    }
       	
   	wp_enqueue_style( 'feed_related_css', ASSETS_PATH . '/css/masonry.css', array() );
   	wp_enqueue_script( 'feed_related_js', ASSETS_PATH . '/js/index.js', array('jquery'), false, true );
		
    $powerd_by = '';

    if(HW_fs()->is_not_paying()){
        $upgradeUrl = HW_fs()->get_upgrade_url();
        $powerd_by = "<br>Powerd By <a href=\"#\">CLEANCODED</a>. <a href=\"{$upgradeUrl}\">Upgrade Now</a>";
        $powerd_by = "<div>{$powerd_by}</div>";
    }

    $html = "
        <div id=\"twitter_feeds\" style=\"display: none\">
            {$html}{$powerd_by}
        </div>
    ";
    echo $html;
}

add_shortcode("TWITTER_FEEDS", "searchAndBuildTweets");