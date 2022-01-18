<?php
/**
 * @package  Flexity
 */
namespace Inc\Base;

class CPTController
{
    public function register() {
        add_action('init', array($this, 'createCPT'));
        add_filter('enter_title_here', array($this, 'changePodcastInputPlaceholder'), 10, 2);
    }

    public function createCPT() {
        $labels = array(
            'name' => __('Podcasts', 'flex'),
            'singular_name' => __('Podcast', 'flex'),
            'all_items' => __('All Podcasts', 'flex'),
            'add_new' => __('Add New', 'flex'),
            'add_new_item' => __('Add New Podcast', 'flex'),
            'edit_item' => __('Edit Podcast', 'flex'),
            'new_item' => __('Add new', 'flex'),
            'view_item' => __('View Podcast', 'flex'),
            'search_items' => __('Search Podcasts', 'flex'),
            'not_found' => __('No Podcasts Found', 'flex'),
            'not_found_in_trash' => __('No Poscasts found in Trash', 'flex'),
        );

        $args = array(
            'labels' => $labels,
            'has_archive' => true,
            'hierarchical' => true,
            'public' => true,
            'publicly_queryable' => true,
            'query_var' => true,
            'capability_type' => 'page',
            'menu_icon' => 'dashicons-format-audio',
            'hierarchical' => false,
            'show_in_admin_bar' => true,
            'supports' => array(
                'title'
            ),
            'rewrite' => array('slug' => 'podcasts'),
        );
        register_post_type('podcast', $args);

        ACFController::addFields();
    }

    public function changePodcastInputPlaceholder($title, $post) {
        if ('podcast' == $post->post_type) {
            $title = 'Enter spotify podcast id';
        }
        return $title;
    }
}