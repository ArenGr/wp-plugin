<?php
/**
 * @package  Flexity
 */
namespace Inc\Base;

class BaseController
{
	public $plugin_path;

	public $plugin_url;

	public $plugin;

    public $user_id;

    public $wpdb;


	public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
        $this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
        $this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/flexity.php';

        add_action('init', array($this, 'getCurrentUserId'));
	}

    public function getCurrentUserId()
    {
        if ( ! function_exists( 'wp_get_current_user' ) ) {
            return 0;
        }
        $user = wp_get_current_user();
        return ( isset( $user->ID ) ? (int) $this->user_id = $user->ID : $this->user_id = 0);
    }
}