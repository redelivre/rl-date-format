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
        add_filter( 'get_the_time',  array($this, 'post_time_ago' ), 10, 3 );
        $this->load_textdomain();
    }
        
    public function load_textdomain() {
    	load_plugin_textdomain( 'rl-date-format', false, dirname( plugin_basename( __FILE__ ) ) . '/../languages' );
    }

    /**
     * Based on https://wpklik.com/wordpress-tutorials/display-time-ago/
     */
    function post_time_ago($the_time, $format, $post) {
    	return sprintf( esc_html__( '%s ago', 'rl-date-format' ), human_time_diff(get_post_time('U', false, $post, true), current_time( 'timestamp' ) ) );
    }
}

new RLDateFormat();