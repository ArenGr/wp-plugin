<?php
/**
 * @package Flexity
 */
namespace Inc\Base;

use Inc\Base\BaseController;

class PageController extends BaseController
{
    public function register() {
        add_action('init', array($this, 'podcastsPage'));
    }

    public function podcastsPage() {
        $page_exist = get_page_by_title('podcasts', 'OBJECT', 'page');
        if (empty($page_exist)) {
            $page_id=wp_insert_post(
                array(
                    'comment_status'=>'close',
                    'ping_status'=>'close',
                    'post_author' => $this->user_id,
                    'post_title'=>'podcasts',
                    'post_name'=>sanitize_title('podcasts'),
                    'post_status'=>'publish',
                    'post_type'=>'page',
                )
            );
                wp_insert_post( $page_id );
        }
    }
}