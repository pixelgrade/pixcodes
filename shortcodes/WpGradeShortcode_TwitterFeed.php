<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_TwitterFeed extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->self_closed = true;
        $this->direct = false;
        $this->name = "TwitterFeed";
        $this->code = "twitterfeed";
        $this->icon = "icon-group";

        $this->params = array(
            'username' => array(
                'type' => 'text',
                'name' => 'Twitter Username',
                'admin_class' => 'span6'
            ),
            'count' => array(
                'type' => 'text',
                'name' => 'Number of Tweets',
                'admin_class' => 'span5 push1'
            ), 
			'class' => array(
                'type' => 'text',
                'name' => 'Class',
                'admin_class' => 'span6'
            ),
        );

	    // allow the theme or other plugins to "hook" into this shortcode's params
	    $this->params = apply_filters('pixcodes_filter_params_for_' . strtolower($this->name), $this->params);

        add_shortcode('twitterfeed', array( $this, 'add_shortcode') );

        // frontend assets needs to be loaded after the add_shortcode function
        $this->frontend_assets["js"] = array(
            'columns' => array(
                'name' => 'frontend_twitterfeed',
                'path' => 'js/shortcodes/frontend_twitterfeed.js',
                'deps'=> array( 'jquery' )
            )
        );
        add_action('wp_footer', array($this, 'load_frontend_assets'));
    }

    public function add_shortcode($atts){
		
		extract( shortcode_atts( array(
            'username' => '',
            'count' => '',
            'class' => '',
        ), $atts ) );

        $this->load_frontend_scripts = true;

	    /**
	     * Template localization between plugin and theme
	     */
	    $located = locate_template("templates/shortcodes/{$this->code}.php", false, false);
	    if(!$located) {
		    $located = dirname(__FILE__).'/templates/'.$this->code.'.php';
	    }
	    // load it
	    ob_start();
	    require $located;
	    return ob_get_clean();
    }
	
	public function get_parsed_tweet ($tweet) {
		// check if any entites exist and if so, replace then with hyperlinked versions
		$tweet_text = $tweet['text'];
		if (!empty($tweet['entities']['urls']) || !empty($tweet['entities']['hashtags']) || !empty($tweet['entities']['user_mentions'])) {
				foreach ($tweet['entities']['urls'] as $url) {
						$find = $url['url'];
						$replace = '<a href="'.$find.'" target="_blank" rel="nofollow">'.$find.'</a>';
						$tweet_text = str_replace($find,$replace,$tweet_text);
				}

				foreach ($tweet['entities']['hashtags'] as $hashtag) {
						$find = '#'.$hashtag['text'];
						$replace = '<a href="http://twitter.com/#!/search/%23'.$hashtag['text'].'" target="_blank" rel="nofollow">'.$find.'</a>';
						$tweet_text = str_replace($find,$replace,$tweet_text);
				}

				foreach ($tweet['entities']['user_mentions'] as $user_mention) {
						$find = "@".$user_mention['screen_name'];
						$replace = '<a href="http://twitter.com/'.$user_mention['screen_name'].'" target="_blank" rel="nofollow">'.$find.'</a>';
						$tweet_text = str_ireplace($find,$replace,$tweet_text);
				}
		}
		
		return $tweet_text;
	}
	
	public function convert_twitter_date( $time ) {
		$date = strtotime( $time );
		//return util::human_time_diff($date);
		return gbs_relative_time($date);
	}
	
	public function gbs_relative_time( $timestamp ){
                     
		$difference = current_time( 'timestamp' ) - $timestamp;

		if ( $difference >= 60*60*24*365 ){        // if more than a year ago
			$int = intval( $difference / ( 60*60*24*365 ) );
			$r = sprintf( _n( '%d year ago', '%d years ago', $int, wpGrade_txtd ), $int );
		} elseif ( $difference >= 60*60*24*7*5 ){  // if more than five weeks ago
			$int = intval( $difference / ( 60*60*24*30 ) );
			$r = sprintf( _n( '%d month ago', '%d months ago', $int, wpGrade_txtd ), $int );
		} elseif ( $difference >= 60*60*24*7 ){        // if more than a week ago
			$int = intval( $difference / ( 60*60*24*7 ) );
			$r = sprintf( _n( '%d week ago', '%d weeks ago', $int, wpGrade_txtd ), $int );
		} elseif ( $difference >= 60*60*24){      // if more than a day ago
			$int = intval( $difference / ( 60*60*24 ) );
			$r = sprintf( _n( '%d day ago', '%d days ago', $int, wpGrade_txtd ), $int );
		} elseif ( $difference >= 60*60 ){         // if more than an hour ago
			$int = intval( $difference / ( 60*60 ) );
			$r = sprintf( _n( '%d hour ago', '%d hours ago', $int, wpGrade_txtd ), $int );
		} elseif ( $difference >= 60 ){            // if more than a minute ago
			$int = intval( $difference / ( 60 ) );
			$r = sprintf( _n( '%d minute ago', '%d minutes ago', $int, wpGrade_txtd ), $int );
		} else {                                // if less than a minute ago
			$r = __( 'moments ago', wpGrade_txtd );
		}

		return $r;
	}
}