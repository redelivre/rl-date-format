<?php

class RLDateFormat {
    protected static $_instance;

    public function __construct() {
        if(! is_object (self::$_instance) ) {
            self::$_instance = $this;
            add_action('init', array($this, 'init') );
        }
    }
    public function init() {
    	$this->load_textdomain();
        add_filter( 'get_the_time',  array($this, 'post_time_ago' ), 10, 3 );
        add_filter( 'date_i18n',  array($this, 'date_i18n' ), 10, 4 );
    }
        
    public function load_textdomain() {
    	load_plugin_textdomain( 'rl-date-format', false, dirname( plugin_basename( __FILE__ ) ) . '/../languages' );
    }

    /**
     * Based on https://wpklik.com/wordpress-tutorials/display-time-ago/
     */
    public function post_time_ago($the_time, $format, $post) {
    	return $this->format_date($the_time, $post);
    }
    
    public function format_date($date, $post = null) {
    	if(isset($post)) {
    		return sprintf( esc_html__( '%s ago', 'rl-date-format' ), human_time_diff(get_post_time('U', false, $post, true), current_time( 'timestamp' ) ) );
    	} elseif(is_int($date)) {
    		return sprintf( esc_html__( '%s ago', 'rl-date-format' ), human_time_diff($date, current_time( 'timestamp' ) ) );
    	}
    	return $date;
    }
    
    /**
     * 
     * @param string $j          Formatted date string.
	 * @param string $req_format Format to display the date.
	 * @param int    $i          Unix timestamp.
	 * @param bool   $gmt        Whether to convert to GMT for time. Default false.
     */
    public function date_i18n($j, $req_format, $i, $gmt) {
    	
    	return $this->format_date($i);
    }
}

new RLDateFormat();