<?php
$content = '';

if ( isset($title) && $title != '') $content .= '<h3>' . $title . '</h3>';

$count = isset( $count ) ? absint( $count ) : 5;

if (!class_exists('StormTwitter')) {
	require_once(WPGRADE_SHORTCODES_PATH . '/vendor/twitter-api/StormTwitter.class.php');
}

global $wpGrade_Options;

$config['key'] = $wpGrade_Options->get('twitter_consumer_key');
$config['secret'] = $wpGrade_Options->get('twitter_consumer_secret');
$config['token'] = $wpGrade_Options->get('twitter_oauth_access_token');
$config['token_secret'] = $wpGrade_Options->get('twitter_oauth_access_token_secret');
$config['screenname'] = $username;
if ( isset($config['cache_expire']) && $config['cache_expire'] < 1) $config['cache_expire'] = 3600;
$config['directory'] = WPGRADE_SHORTCODES_PATH . 'vendor/twitter-api/cache';

$twitter = new StormTwitter($config);
$results = $twitter->getTweets($count, $username);

$link = 'https://twitter.com/'. $username;


if ( $results ){
//        	$content .= '<div class="twitter-icon"><i class="icon-twitter"></i></div>';
	$content .= '<div class="twitter-shortcode-tweets_container">';
	$content .= '<ul class="twitter-shortcode-tweets slides '.$class.'">';
	foreach ($results as $key => $result) {
		$content .= '<li class="twitter-shortcode-tweet slide">
                    	<div class="twitter-shortcode-tweet-meta">
                        <span class="twitter-shortcode-screenname">' . ucwords($config['screenname']) . '</span>' .
			'<span class="twitter-shortcode-username"><a href="'.$link.'">@' . $config['screenname'] . '</a></span>' .
			'<span class="twitter-shortcode-tweet-date">' . $this->convert_twitter_date($result["created_at"]) . '</span></div>
                         <div class="twitter-shortcode-tweet-content">'.$this->get_parsed_tweet($result) .'</div>
                </li>';

	}
	$content .= '</ul>';
	$content .= '</div>';
}

return $content;