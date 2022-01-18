<?php
/**
 * @package  Flexity
 */
namespace Inc\Base;

use Config\Config;

class DatabaseController extends BaseController
{

    public function register()
    {
        add_action( 'init', array($this, 'createTablePodcasts' ));
        add_action( 'init', array($this, 'createTableTokens' ));
    }

    public function createTablePodcasts()
    {
        $charset_collate = $this->wpdb->get_charset_collate();
        $table_name = Config::TABLE_WP_FX_PODCASTS;

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (        
	    id mediumint(9) NOT NULL AUTO_INCREMENT,
        post_id varchar(255) DEFAULT NULL ,
        track_id varchar(255) DEFAULT NULL ,
        track_name varchar(255) DEFAULT NULL,
        track_href varchar(255) DEFAULT NULL,
        track_uri varchar(255) DEFAULT NULL,
        track_duration_ms varchar(255) DEFAULT NULL,
        track_release_date DATE DEFAULT NULL,
        album_image varchar(255) DEFAULT NULL,
        artist_name varchar(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        
        PRIMARY KEY  (id),
		UNIQUE KEY id (id)
	) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public function createTableTokens(){
        $charset_collate = $this->wpdb->get_charset_collate();
        $table_name = Config::TABLE_WP_FX_TOKENS;

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (        
	    id mediumint(9) NOT NULL AUTO_INCREMENT,
        access_token TEXT DEFAULT NULL ,
        refresh_token TEXT DEFAULT NULL ,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        
        PRIMARY KEY  (id),
		UNIQUE KEY id (id)
	) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
}