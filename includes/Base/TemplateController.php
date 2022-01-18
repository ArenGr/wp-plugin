<?php
/**
 * @package  Flexity
 */

namespace Inc\Base;

use Config\Config;
use Inc\Base\BaseController;

class TemplateController extends BaseController
{
    public $templates;

    public function register() {

        $this->templates=array(
//            'templates/podcasts.php'=>'Podcast Page'
        );

        add_filter('theme_page_templates', array($this, 'customTemplate'));
        add_filter('template_include', array($this, 'loadTemplate'));
    }

    public function customTemplate($templates) {
        $templates=array_merge($templates, $this->templates);
        return $templates;
    }

    public function loadTemplate($template) {
        global $post;

        if (!$post) {
            return $template;
        }

        if (!is_admin()) {
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//            if (is_page("podcasts") && get_post_type($post) == "page") {
            if ($actual_link=='https://'.Config::SITE_DOMAIN.'/podcasts/') {
                $file = $this->plugin_path.'templates/podcasts.php';
                if (file_exists($file)) {
                    return $file;
                }
            };

            if (get_post_type($post) == "podcast") {
                $file=$this->plugin_path . 'templates/podcast.php';
                if (file_exists($file)) {
                    return $file;
                }
            }

            $template_name=get_post_meta($post->ID, '_wp_page_template', true);

            if (!isset($this->templates[$template_name])) {
                return $template;
            }

            $file=$this->plugin_path . $template_name;

            if (file_exists($file)) {
                return $file;
            }
            return $template;
        }
    }
}