<?php
/**
 * @package  Flexity
 */

namespace Inc\Base;

use Config\Config;
use Inc\Base\BaseController;

class Enqueue extends BaseController
{
    public function register() {
        add_action('wp_loaded', array($this, 'enqueue'));
        add_action('wp_default_scripts', function ($scripts) {
            if (!empty($scripts->registered['jquery'])) {
                $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
            }
        });
    }

    function enqueue() {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $query = parse_url($actual_link);
        $query = explode('/', $query["path"]);
        $query = array_filter($query);
        $podcast_page = count($query) > 1 ? true : false;
        $podcasts_page = count($query ) ==1 && end($query)=='podcasts' ? true : false;

        if ( $podcasts_page || $podcast_page) {

                wp_register_style('bootstrap-css', $this->plugin_url . 'assets/bootstrap/css/bootstrap.min.css');
                wp_enqueue_style('bootstrap-css');
                wp_register_style('owlcarousel-css', $this->plugin_url . 'assets/owlcarousel/dist/assets/owl.carousel.min.css');
                wp_enqueue_style('owlcarousel-css');
                wp_register_style('owlcarousel-theme', $this->plugin_url . 'assets/owlcarousel/dist/assets/owl.theme.default.min.css');
                wp_enqueue_style('owlcarousel-them');
                wp_register_style('fontawesome-css', $this->plugin_url . 'assets/fontawesome/css/all.min.css');
                wp_enqueue_style('fontawesome-css');
                wp_enqueue_style('fx-podcasts-css', $this->plugin_url . 'assets/css/podcasts.css', array(), '1', 'all');
                wp_enqueue_style('fx-podcast-css', $this->plugin_url . 'assets/css/podcast.css', array(), '1', 'all');
                wp_enqueue_style('fx-modal-css', $this->plugin_url . 'assets/css/modal.css', array(), '1', 'all');

                wp_deregister_script('jquery');
                wp_register_script('jquery', '//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js', false, '3.6.0');
                wp_enqueue_script('jquery');

                wp_register_script('bootstrap-js', $this->plugin_url . 'assets/bootstrap/js/bootstrap.min.js');
                wp_enqueue_script('bootstrap-js');
                wp_register_script('owlcarousel-js', $this->plugin_url . 'assets/owlcarousel/dist/owl.carousel.min.js', array('jquery'), false, true);
                wp_enqueue_script('owlcarousel-js');
        }
    }
}