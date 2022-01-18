<?php
/**
 * Trigger this file on Plugin uninstall
 *
 * @package  Flexity
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

$podcasts = get_posts( array( 'post_type' => 'podcast', 'numberposts' => -1 ) );

foreach( $podcasts as $podcast ) {
    wp_delete_post( $podcast->ID, true );
}
