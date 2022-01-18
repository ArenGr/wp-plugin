<?php
/**
 * @package  Flexity
 */

namespace Inc\Base;

use Config\Config;
use Inc\Api\SpotifyApi;
use Inc\Helpers\SlugHelper;
use Inc\Services\FileService;

class PodcastController extends BaseController
{
    public function register() {
        add_action('transition_post_status', array($this, 'addPodcast'), 10, 3);
        add_action('delete_podcast', array($this, 'deletePodcast'), 10, 3);
    }

    public function addPodcast($new_status, $old_status, $post) {
        if( 'publish' == $new_status && 'publish' != $old_status && $post->post_type == 'podcast' ) {
            $post_id = $post->ID;
            $podcast_id = $post->post_title;
            if ($podcast_id) {
                $podcast = SpotifyApi::getTrackById($podcast_id);
                if ($podcast) {
                    $image_new_name = time();
                    for ($i=0; $i<3; $i++) {
                        $image_url = $podcast['album']['images'][$i]['url'];
                        $image_size = $podcast['album']['images'][$i]['width'];
                        $image_path = FileService::savePodcastImage($image_url, $image_size, $image_new_name);
                    }
                    if (Model::insertPodcast($post_id, $podcast, $this->wpdb, $image_path)) {
                        echo 'Podcast has been save';
                    }
                } else {
                    return false;
                }
            } else {
                ?>
                <div class="update-nag notice row alert alert-danger">
                    <?php _e('Podcast ID can\'t be empty. Please, fill up it!', 'flexity'); ?>
                </div>
                <?php
                return false;
            }
            $podcast_name = SlugHelper::slugify($podcast['album']['name']);

            $this->wpdb->update('wp_posts',
                ['post_title' => $podcast['album']['name'], 'post_name' => $podcast_name],
                ['ID' => $post_id]
            );
        }
    }

    public function deletePodcast($post_id)
    {
        if (get_post_type($post_id) == 'podcast') {
            global $wpdb;
            $table = Config::TABLE_WP_FX_PODCASTS;
            $podcast_image_path = $wpdb->get_results("SELECT album_image FROM `$table` WHERE post_id = $post_id");
            if ($podcast_image_path)
                $podcast_image_abs_path = plugin_dir_path(dirname(__FILE__, 2)) . $podcast_image_path[0]->album_image;

            $is_podcast_deleted = $wpdb->query("DELETE  FROM wp_podcasts WHERE post_id = $post_id");

            if ($is_podcast_deleted) {
                if ($podcast_image_path && file_exists($podcast_image_abs_path)) {
                    unlink($podcast_image_abs_path);
                } else {

                }
            } else {

            }
        }
    }
}